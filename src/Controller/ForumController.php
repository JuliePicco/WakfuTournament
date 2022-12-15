<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostType;
use App\Form\TopicType;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ForumController extends AbstractController
{
    // * VUE DU FORUM GLOBAL

    /**
     * @Route("/forum", name="app_forum")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Category::class)->findBy([], ["id" => "ASC"]);
        $subCategories = $doctrine->getRepository(SubCategory::class)->findBy([], ["id" => "ASC"]);
        $limitedTopics = $doctrine->getRepository(Topic::class)->findBy([],["id"=>"DESC"],3);

        return $this->render('forum/index.html.twig', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'limitedTopics' => $limitedTopics
        ]);
    }

    /**
     * @Route("/subCategory/{id}/newTopic", name="newTopic")
     */
    public function newTopic(ManagerRegistry $doctrine, SubCategory $subCategory, Topic $topic =  null, Request $request){
        
        if ($this->getUser()){

            $user = $this->getUser();

            $topic = new Topic();

            $form = $this->createForm(TopicType::class, $topic);
            
            // gère la requête envoyée dans le formulaire
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $topic->setSubCategory($subCategory);
                $topic->setUser($user);

                $entityManager = $doctrine->getManager(); 

                // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
                $entityManager->persist($topic);
                $entityManager->flush();

                // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
                return $this->redirectToRoute('subCategory', ['id'=>$subCategory->getId()]);
            }

            // Permet d'afficher le formulaire d'add character
            return $this->render('forum/newTopic.html.twig', [
                'newTopicForm' => $form->createView(),
                'topicId' => $topic->getId(),
            ]);

        } else{

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');
        }
    }



    
    // ! il est préférable de mettre ces fonction à la fin pour pas qu'elle rentre en conflit avec les autres (à cause de la route "/{id}")

    //* VUE DES SOUS CATEGORIES

    /**
     * @Route("/subCategory/{id}", name="subCategory")
     */
    public function subCategoryList(SubCategory $subCategory): Response
    {               
       
        return $this->render('forum/subCategory.html.twig', [
            'subCategory' => $subCategory,  
                 
        ]);
    }


    //* VUE DES TOPICS avec l'ajout de réponse à celui ci

    /**
     * @Route("/topic/{id}", name="topic")
     */
    public function topic(ManagerRegistry $doctrine, Post $post =null, Request $request, Topic $topic): Response
    {            
        $form = $this->createForm(PostType::class, $post);
            
        // gère la requête envoyée dans le formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $post = $form ->getData();
            
            $topic -> addPost($post);
           
            $post->setUser($this->getUser());

            $entityManager = $doctrine->getManager(); 

            // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
            $entityManager->persist($post);
            $entityManager->flush();

            // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
            return $this->redirectToRoute('topic', ['id'=>$topic->getId()]);
        } 
        
        return $this->render('forum/topic.html.twig', [
            'topic' => $topic,
            'newPostForm' => $form->createView(), 
           
        ]);
    }


}
