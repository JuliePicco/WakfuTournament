<?php

namespace App\Controller;

use DateTime;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Server;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="app_team")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $teams = $doctrine->getRepository(Team::class)->findBy([], ["teamName" => "ASC"]);

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }


    // * Créer une équipe :

    /**
     * @Route("/team/addTeam", name="add_team")
     */
    public function addTeam(ManagerRegistry $doctrine, Team $team = null, Request $request)
    {

        // Vérifie qu'il y a un user en session
        if ($this->getUser()){

            //recupère l'user en session
            $user = $this->getUser();

            $team = new Team();

            // On recupère le logo par défaut qui sera potentiellement changé)
            $teamLogo = $team ->getTeamLogo();

            // Création du formulaire par rapport au teamtype
            $form = $this->createForm(TeamType::class, $team);

            // gère la requête envoyée dans le formulaire
            $form->handleRequest($request);

            if($form->isSubmitted()){
                if($form->isValid()){
          
                    // Recupération de la nouvelle saisi dans le formulaire
                    $newTeamLogo = $form->get('teamLogo')->getData();

                    // On ajoute l'utilisateur en session comme étant leader et comment faisant partit de l'équipe
                    $user->addLeaderTeam($team);
                    $user->addTeam($team);

                    $entityManager = $doctrine->getManager();           
                    
                    if($newTeamLogo!= $teamLogo){
        
                        if(isset($newTeamLogo)){

                            // Permet de vérifier le format  utilisé d'une image et de voir s'il est autorisé.
                            if(in_array($newTeamLogo-> guessExtension(), ["png", "jpeg", "jpg", "webp" ])){

                                // Condition de la taille max autorisé (200ko)
                                if($newTeamLogo->getSize() <= 204800){

                                    // md5 (Message Digest 5) => C'est un algorithme de hachage faible
                                    // uniqId => Génère un identifiant unique basé sur la date et l'heure courante 

                                    $file = md5(uniqid()) . '.' . $newTeamLogo -> guessExtension();

                                    // On déplace le fichier teamLogo de l'utilisateur dans son dossier img/user/team via le paramettre 'teamLogo_directory' situé dans le service.yaml
                                    $newTeamLogo -> move(
                                        $this -> getParameter('teamLogo_directory'),
                                        $file
                                    );

                                    // On récupère dans notre disque local l'image actuel avant sa modification par l'utilisateur. On passe donc par le getParameter('teamLogo_directory') pour le retrouver dans son fichier (team)
                                    // pour ce faire j'utilise de nouveau le getParameter(' teamLogo_directory') pour localiser le fichier dans public/img/user/team
                                    $teamLogoName  = $this -> getParameter('teamLogo_directory'). '/' . $team -> getTeamLogo();

                                    if($teamLogoName != $this -> getParameter('teamLogo_directory') . '/team-default.jpg'){

                                        // file_exists() => Permet de vérifier si "$teamLogoName" existe
                                        // unlink() => Permet de supprimer le fichier ou dossier qui sera remplacé

                                        if(file_exists($teamLogoName) ){
                                            unlink($teamLogoName);
                                        }

                                    }

                                    // Initialisation de la nouvelle image
                                    $team-> setTeamLogo($file);
                                            
                                    // On accède à la BDD
                                    $entityManager = $doctrine->getManager(); 

                                    // On persiste/prepare l'objet
                                    $entityManager->persist($user);
                                    // On flush/execute ce qui a été demandé 
                                    $entityManager->flush();

                                } else {

                                    // erreur si le poid dépasse les 200ko
                                    $this -> addFlash('warning', "Votre image ne doit pas dépasser les 200Ko !");

                                }

                            }else {

                                // erreur si le format de l'image est mauvais
                                $this -> addFlash('warning', "Le format de votre image n'est pas supporté ! Format possible : png, jpeg, jpg et webp");
                            }
                        }
                    }

                    // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
                    $entityManager->persist($team);
                    $entityManager->flush();

                    // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
                    return $this->redirectToRoute('profil_user', ['id'=>$user->getId()]);
                }
            }

            // Permet d'afficher le formulaire d'add tournament
            return $this->render('team/addTeam.html.twig', [
                'addTeamForm' => $form->createView(),
                'user' => $user,          
            ]);

        } else {
            
            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');
            
        } 
    }


    /**
     * @Route("/team/editTeam/{idTeam}", name="edit_team")
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
     */
    public function editTeam(ManagerRegistry $doctrine, Team $team =  null, Request $request)
    {
        // Vérifie qu'il y a un user en session
        if ($this->getUser() == $team -> getLeader()){

            //recupère l'user en session
            $user = $this->getUser();

            $teamLogo = $team -> getTeamLogo();
            
            $form = $this->createForm(TeamType::class, $team);
            // gère la requête envoyée dans le formulaire
            $form->handleRequest($request);

           
            if($form->isSubmitted()){
                if($form->isValid()){

                    // getData : permet de recuperer les données s'il y en a (utile pour l'edit)
                    $team = $form->getData();
                 
                    // Recupération de la nouvelle saisi dans le formulaire
                    $newTeamLogo = $form->get('teamLogo')->getData();

                    $user->addLeaderTeam($team);
                    $user->addTeam($team);

                    $entityManager = $doctrine->getManager();

                    
                    if($newTeamLogo!= $teamLogo){
        
                        if(isset($newTeamLogo)){

                            // Permet de vérifier le format  utilisé d'une image et de voir s'il est autorisé.
                            if(in_array($newTeamLogo-> guessExtension(), ["png", "jpeg", "jpg", "webp" ])){

                                // Condition de la taille max autorisé (200ko)
                                if($newTeamLogo->getSize() <= 204800){

                                    // md5 (Message Digest 5) => C'est un algorithme de hachage faible
                                    // uniqId => Génère un identifiant unique basé sur la date et l'heure courante 

                                    $file = md5(uniqid()) . '.' . $newTeamLogo -> guessExtension();

                                    // On déplace le fichier teamLogo de l'utilisateur dans son dossier img/user/team via le paramettre 'teamLogo_directory' situé dans le service.yaml
                                    $newTeamLogo -> move(
                                        $this -> getParameter('teamLogo_directory'),
                                        $file
                                    );

                                    // On récupère dans notre disque local l'image actuel avant sa modification par l'utilisateur. On passe donc par le getParameter('teamLogo_directory') pour le retrouver dans son fichier (team)
                                    // pour ce faire j'utilise de nouveau le getParameter(' teamLogo_directory') pour localiser le fichier dans public/img/user/team
                                    $teamLogoName  = $this -> getParameter('teamLogo_directory'). '/' . $team -> getTeamLogo();

                                    if($teamLogoName != $this -> getParameter('teamLogo_directory') . '/team-default.jpg'){

                                        // file_exists() => Permet de vérifier si "$teamLogoName" existe
                                        // unlink() => Permet de supprimer le fichier ou dossier qui sera remplacé

                                        if(file_exists($teamLogoName) ){
                                            unlink($teamLogoName);
                                        }

                                    }

                                    // Initialisation de la nouvelle image
                                    $team-> setTeamLogo($file);
                                            
                                    // On accède à la BDD
                                    $entityManager = $doctrine->getManager(); 

                                    // On persiste/prepare l'objet
                                    $entityManager->persist($team);
                                    // On flush/execute ce qui a été demandé 
                                    $entityManager->flush();

                                } else {

                                    // erreur si le poid dépasse les 200ko
                                    $this -> addFlash('warning', "Votre image ne doit pas dépasser les 200Ko !");

                                }

                            }else {

                                // erreur si le format de l'image est mauvais
                                $this -> addFlash('warning', "Le format de votre image n'est pas supporté ! Format possible : png, jpeg, jpg et webp");
                            }
                        }
                    }

                    // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
                    $entityManager->persist($team);
                    $entityManager->flush();

                    // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
                    return $this->redirectToRoute('show_team', ['id'=>$team->getId()]);
                }
            }

            // Permet d'afficher le formulaire d'add tournament
            return $this->render('team/editTeam.html.twig', [
                'addTeamForm' => $form->createView(),
                'user' => $user,
                'edit' => $team->getId(),
            
            ]);

        } else {
            
            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');
            
        } 
    }


    /**
     * @Route("/team/deleteTeam/{idTeam}", name="delete_team")
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
    */
    public function deleteTeam(ManagerRegistry $doctrine, Team $team): Response
    {
        if($this -> getUser() && $this -> getUser() == $team -> getLeader()){

            $user = $this->getUser();

            $entityManager = $doctrine->getManager(); 
            $entityManager->remove($team);
            $entityManager->flush();
    
            return $this->redirectToRoute('profil_user', ['id'=>$user->getId()]);

        } else {

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this -> redirectToRoute('app_home');
        }
    
    }

     /**
     * @Route("/joinTeam/{idTeam}", name="join_team")
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
     */
    public function joinTeam(ManagerRegistry $doctrine, Team $team){

        // on ajoute des contraintes pour éviter qu'une personne face des modifications via l'URL
        if ($this->getUser() && $this->getUser()->nbTeams() < 3 && $team->nbMembers() < 6){

            $user=$this->getUser();

            //Récupération de la méthode addMember dans l'entité Team
            $team->addMember($user);

            // nous permet d'acceder à la fonction persist et flush
            $entityManager = $doctrine->getManager();
    
            $entityManager->persist($user);
            $entityManager->flush();
 
         return $this->redirectToRoute('show_team', ['id'=>$team->getId()] );

        } else{

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');

        }
    }


    /**
     * @Route("/leaveTeam/{idTeam}", name="leave_team")
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
     */
    public function leaveTeam(ManagerRegistry $doctrine, Team $team){

        if ($this->getUser()){

            $user=$this->getUser();

            //Récupération de la méthode removeMember dans l'entité team
            $team->RemoveMember($user);

            // nous permet d'acceder à la fonction persist et flush
            $entityManager = $doctrine->getManager();
    
            $entityManager->persist($user);
            $entityManager->flush();
 
         return $this->redirectToRoute('show_team', ['id'=>$team->getId()] );

        } else{

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');

        }
    }


      // ! il est préférable de mettre cette fonction à la fin pour pas qu'elle rentre en conflit avec les autres (à cause de la route "/{id}")
    /**
     * @Route("/showTeam/{id}", name="show_team")
     */
    public function show(Team $team, TeamRepository $tr): Response
    {
        $notMembers = $tr->findNotMembers($team->getId());
        $now = new DateTime() ;
         
        return $this->render('team/showTeam.html.twig', [
            'team' => $team,
            'notMembers' => $notMembers,
            'now' => $now,
 
        ]);
    }



}
