<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Tournament;
use App\Form\TournamentType;
use App\Repository\TournamentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TournamentController extends AbstractController
{
    /**
     * @Route("/tournament", name="app_tournament")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $tournaments = $doctrine->getRepository(Tournament::class)->findBy([], ["startDate" => "ASC"]);

        return $this->render('tournament/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }


    /**
     * @Route("/tournament/finished", name="app_finishedTournaments")
     */
    public function finishedTournaments(ManagerRegistry $doctrine): Response
    {
        $tournaments = $doctrine->getRepository(Tournament::class)->findBy([], ["startDate" => "DESC"]);

        return $this->render('tournament/finishedTournaments.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }


    // * Permet d'ajouter un tournois

    /**
     * @Route("/tournament/addTournament", name="add_tournament")
     */
    public function addTournament(ManagerRegistry $doctrine, Tournament $tournament =  null, Request $request)
    {
        // Vérifie qu'il y a un user en session
        if ($this->getUser()){

            //recupère l'user en session
            $user = $this->getUser();

            $tournament = new Tournament();

            $imgTournament = $tournament ->getImgTournament();

            $form = $this->createForm(TournamentType::class, $tournament);
            // gère la requête envoyée dans le formulaire
            $form->handleRequest($request);

            if($form->isSubmitted()){
                if($form->isValid()){

                    // Recupération de la nouvelle saisi dans le formulaire
                    $newImgTournament = $form->get('imgTournament')->getData();

                    $user->addTournament($tournament);
                    $entityManager = $doctrine->getManager();
                    
                    if($newImgTournament != $imgTournament){
        
                        if(isset($newImgTournament)){

                            // Permet de vérifier le format  utilisé d'une image et de voir s'il est autorisé.
                            if(in_array($newImgTournament-> guessExtension(), ["png", "jpeg", "jpg", "webp" ])){

                                // Condition de la taille max autorisé (200ko)
                                if($newImgTournament->getSize() <= 204800){

                                    // md5 (Message Digest 5) => C'est un algorithme de hachage faible
                                    // uniqId => Génère un identifiant unique basé sur la date et l'heure courante 

                                    $file = md5(uniqid()) . '.' . $newImgTournament -> guessExtension();

                                    // On déplace le fichier ImgTournament de l'utilisateur dans son dossier img/user/tournament via le paramettre 'tournamentImg_directory' situé dans le service.yaml
                                    $newImgTournament -> move(
                                        $this -> getParameter('tournamentImg_directory'),
                                        $file
                                    );

                                    // On récupère dans notre disque local l'avatar actuel avant sa modification par l'utilisateur. On passe donc par le getParameter('avatar_directory') pour le retrouver dans son fichier (avatar)
                                    // pour ce faire j'utilise de nouveau le getParameter(' tournamentImg_directory') pour localiser le fichier dans public/img/avatars 
                                    $imgTournamentName = $this -> getParameter('tournamentImg_directory'). '/' . $tournament -> getImgTournament();

                                    if($imgTournamentName != $this -> getParameter('tournamentImg_directory') . '/tournament-default.jpg'){

                                        // file_exists() => Permet de vérifier si "$imgTournamentName" existe
                                        // unlink() => Permet de supprimer le fichier ou dossier qui sera remplacé

                                        if(file_exists($imgTournamentName) ){
                                            unlink($imgTournamentName);
                                        }

                                    }

                                    // Initialisation du nouvelle avatar
                                    $tournament-> setImgTournament($file);
                                            
                                    // On accède à la BDD
                                    $entityManager = $doctrine->getManager(); 

                                    // On persiste/prepare l'objet
                                    $entityManager->persist($tournament);
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
                    $entityManager->persist($tournament);
                    $entityManager->flush();

                    // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
                    return $this->redirectToRoute('profil_user', ['id'=>$user->getId()]);
                }
            }

            // Permet d'afficher le formulaire d'add tournament
            return $this->render('tournament/addTournament.html.twig', [
                'addTournamentForm' => $form->createView(),
                'user' => $user,
                'tournamentId' => $tournament->getId(),
            
            ]);

        } else {
            
            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');
            
        } 
    }


    //* Permet de s'inscrire à un tournois

    /**
     * @Route("/subscribe/tournament/{idTournament}/team/{idTeam}", name="inscription_team")
     * @ParamConverter("tournament", options={"mapping": {"idTournament" : "id"}})
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
    */
    public function tournamentInscription(ManagerRegistry $doctrine, Tournament $tournament, Team $team ) {
            // on recherche si l 'utilisateur est le leader
        if ($this->getUser() == $team -> getLeader() && 
            //si l'utilisateur n est pas l'organisateur du tournois
            $this->getUser() != $tournament ->getOrganisator() 
            // et si le tournois n'est pas complet,
            // $tournament->Nbreserved() != $tournament->getNbTeamLimit()
            )
            // alors, l'utilisateur peut s'inscrire au tournois
            {

                
            // on récupère la méthode addParticipatingTeam dans tournament
            $tournament -> addParticipatingTeam($team);

            // nous permet d'acceder à la fonction persist et flush
            $entityManager = $doctrine->getManager();

            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('show_tournament', ['id'=>$tournament->getId()] );

        } else {

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');

        }
    }


    /**
     * @Route("/unsubscribe/tournament/{idTournament}/team/{idTeam}", name="desinscrire_team")
     * @ParamConverter("tournament", options={"mapping": {"idTournament" : "id"}})
     * @ParamConverter("team", options={"mapping": {"idTeam" : "id"}})
    */
    public function tournamentDesinscrire(ManagerRegistry $doctrine, Tournament $tournament, Team $team){
        
        if ($this->getUser() == $team -> getLeader()){

            // on récupère la méthode removeParticipatingTeam dans tournament
            $tournament -> removeParticipatingTeam($team);

            // nous permet d'acceder à la fonction persist et flush
            $entityManager = $doctrine->getManager();

            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('show_tournament', ['id'=>$tournament->getId()] );

        } else {

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');

        }
    }




     // ! il est préférable de mettre cette fonction à la fin pour pas qu'elle rentre en conflit avec les autres (à cause de la route "/{id}")
    /**
     * @Route("/showTournament/{id}", name="show_tournament")
     */
    public function show(ManagerRegistry $doctrine, Tournament $tournament, TournamentRepository $unregistered): Response
    {
        // fonction qui permet de trouver les teams ou l'on est leader qui ne sont pas enregistré dans un tournois
        $unregisteredTeams = $unregistered -> findUnregistered($tournament->getId());

        return $this->render('tournament/showTournament.html.twig', [
            'tournament' => $tournament,
            'unregisteredTeams' => $unregisteredTeams
        ]);
    }


}
