<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Topic;
use App\Form\NewsType;
use App\Entity\Tournament;
use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findBy([], ["pseudonyme" => "ASC"]);
        $tournaments = $doctrine->getRepository(Tournament::class)->findBy([], ["tournamentName" => "ASC"]);
        $teams = $doctrine->getRepository(Team::class)->findBy([], ["teamName" => "ASC"]);

        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'tournaments' => $tournaments,
            'teams' => $teams,
        ]);
    }

    //* Page d'accueil

    // Ajouter d'une news

    /**
     * @Route("admin/addNews", name="add_news")
     */
    public function addNews(ManagerRegistry $doctrine, News $news = null, Request $request){
        
        $this-> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $news = new News();

        $illustrationNews = $news ->getNewsIllustration();

        $form = $this->createForm(NewsType::class, $news);

        // gère la requête envoyée dans le formulaire
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){

                $newIllustrationNews = $form->get('newsIllustration')->getData();

                $entityManager = $doctrine->getManager(); 

                if($newIllustrationNews != $illustrationNews){
            
                    if(isset($newIllustrationNews)){

                        // Permet de vérifier le format  utilisé d'une image et de voir s'il est autorisé.
                        if(in_array($newIllustrationNews-> guessExtension(), ["png", "jpeg", "jpg", "webp" ])){

                            // Condition de la taille max autorisé (300ko)
                            if($newIllustrationNews->getSize() <= 300000){

                                // md5 (Message Digest 5) => C'est un algorithme de hachage faible
                                // uniqId => Génère un identifiant unique basé sur la date et l'heure courante 

                                $file = md5(uniqid()) . '.' . $newIllustrationNews -> guessExtension();

                                // On déplace le fichier imgNews de l'utilisateur dans son dossier img/news via le paramettre 'newsImg_directory' situé dans le service.yaml
                                $newIllustrationNews -> move(
                                    $this -> getParameter('newsImg_directory'),
                                    $file
                                );

                                // On récupère dans notre disque local l'avatar actuel avant sa modification par l'utilisateur. On passe donc par le getParameter('newsImg_directory') pour le retrouver dans son fichier 
                                // pour ce faire j'utilise de nouveau le getParameter(' newsImg_directory') pour localiser le fichier dans public/img/news
                                $imgNewsName = $this -> getParameter('newsImg_directory'). '/' . $news -> getNewsIllustration();

                                if($imgNewsName != $this -> getParameter('newsImg_directory') . '/news-default.jpg'){

                                    // file_exists() => Permet de vérifier si "$imgNewsName" existe
                                    // unlink() => Permet de supprimer le fichier ou dossier qui sera remplacé

                                    if(file_exists($imgNewsName) ){
                                        unlink($imgNewsName);
                                    }

                                }

                                // Initialisation du nouvelle avatar
                                $news-> setNewsIllustration($file);
                                        
                                // On accède à la BDD
                                $entityManager = $doctrine->getManager(); 

                                // On persiste/prepare l'objet
                                $entityManager->persist($news);
                                // On flush/execute ce qui a été demandé 
                                $entityManager->flush();

                            } else {

                                // erreur si le poid dépasse les 200ko
                                $this -> addFlash('warning', "Votre image ne doit pas dépasser les 300Ko !");

                            }

                        }else {

                            // erreur si le format de l'image est mauvais
                            $this -> addFlash('warning', "Le format de votre image n'est pas supporté ! Format possible : png, jpeg, jpg et webp");
                        }
                    }
                }

                // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
                $entityManager->persist($news);
                $entityManager->flush();

                // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
                return $this->redirectToRoute('app_home');
            }
        }

        // Permet d'afficher le formulaire d'add character
        return $this->render('admin/addNews.html.twig', [
            'newsForm' => $form->createView(),
            'newsId' => $news->getId(),
        ]);
    }




    //* Gestion des Utilisateurs

     /**
     * @Route("/admin/deleteUserAccount/{idUser}", name="delete_user_account")
     * @ParamConverter("user", options={"mapping": {"idUser" : "id"}})
     */
    public function deleteUserAccount(ManagerRegistry $doctrine, User $user, TopicRepository $tr, PostRepository $pr, Request $request)
    {
        $this-> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // On accède à la BDD
        $entityManager =  $doctrine -> getManager(); 

        $posts = $pr->findBy(['user' => $user -> getId()]);
        $topics = $tr->findBy(['user' => $user -> getId()]);
       

        foreach($posts as $post){

            $post->setUser(null);
            $entityManager->persist($post);
            $entityManager->flush();
        }

        foreach($topics as $topic){
            $topic->setUser(null);
            $entityManager->persist($topic);
            $entityManager->flush();
        }

        // On persiste/prepare l'objet
        $entityManager->remove($user);
        // On flush/execute ce qui a été demandé 
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');

    }


    //* Gestion des Equipes

    /**
     * @Route("/admin/adminDeleteTeam/{idTeam}", name="admin_delete_team")
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
    */
    public function adminDeleteTeam(ManagerRegistry $doctrine, Team $team): Response
    {
        $this-> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $doctrine->getManager(); 
        $entityManager->remove($team);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    
    }


    //* Gestion des Tournois

     /**
     * @Route("/admin/adminDeleteTournament/{idTournament}", name="admin_delete_tournament")
     * @ParamConverter("tournament", options={"mapping": {"idTournament" : "id"}})
    */
    public function adminDeleteTournament(ManagerRegistry $doctrine, Tournament $tournament): Response
    {
        $this-> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
      
        $entityManager = $doctrine->getManager(); 
        $entityManager->remove($tournament);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    
    }



    //* Gestion du forum par l'admin

    // ajout d'une subcategory

    /**
     * @Route("/newSubCategory", name="new_SubCategory")
     */
    public function newSubCategory(ManagerRegistry $doctrine, SubCategory $subCategory = null, Request $request){
        
        $this-> denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $subCategory = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $subCategory);
        
        // gère la requête envoyée dans le formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $doctrine->getManager(); 

            // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
            $entityManager->persist($subCategory);
            $entityManager->flush();

            // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
            return $this->redirectToRoute('app_forum');
        }

        // Permet d'afficher le formulaire d'add character
        return $this->render('admin/newSubCategory.html.twig', [
            'newSubCategoryForm' => $form->createView(),
            'subCategoryId' => $subCategory->getId(),
        ]);
    }

  




    // lock unlock un topic

    /**
     * @Route("/admin/lockTopic/{id}", name="lockTopic")
     */
    public function lockTopic(ManagerRegistry $doctrine, Topic $topic): Response
    {
        $topic = $doctrine->getRepository(TopicRepository::class)->findOneBy(['topic' => $topic->getId()],[]);
  
    
        return $this->render('forum/topic.html.twig', [
            'controller_name' => 'TopicController',
        ]);
    }

    /**
     * @Route("/admin/unlockTopic/{id}", name="unlockTopic")
     */
    public function unlockTopic(ManagerRegistry $doctrine, Topic $topic): Response
    {
        $topic = $doctrine->getRepository(TopicRepository::class)->findOneBy(['topic' => $topic->getId()],[]);
  
        return $this->render('forum/topic.html.twig', [
            'controller_name' => 'TopicController',
        ]);
    
    }



}
        