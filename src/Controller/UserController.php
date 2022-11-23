<?php

namespace App\Controller;

use doctrine;
use App\Entity\User;
use App\Entity\Server;
use App\Entity\Character;
use App\Form\CharacterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findBy([], ["pseudonyme" => "ASC"]);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    
    // * Permet d'ajouter un personnage

    /**
     * @Route("/user/{id}/addCharacter", name="add_character")
     */
    public function addCharacter(ManagerRegistry $doctrine, Character $character =  null, User $user, Request $request)
    {
        $character = new Character();

        $form = $this->createForm(CharacterType::class, $character);
        
        // gère la requête envoyée dans le formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->addCharacter($character);
            $entityManager = $doctrine->getManager(); 

            // lorsque l'on ajoute en BDD, on passe toujours par ces 2 lignes de commandes (persist qui est égale au prepare, et flush qui est égal au insert into (execute) et qui envoi en bdd)
            $entityManager->persist($character);
            $entityManager->flush();

            // permet de rediriger vers la bonne vue qui correspond au profil de l'utilisateur
            return $this->redirectToRoute('profil_user', ['id'=>$user->getId()]);
        }

        // Permet d'afficher le formulaire d'add character
        return $this->render('user/addCharacter.html.twig', [
            'addCharacterForm' => $form->createView(),
            'user' => $user,
            'characterId' => $character->getId(),
         
        ]);

    }

    // * suppression d'un personnage

    /**
     * @Route("/user/{idUser}/deleteCharacter/{idCharacter}", name="delete_character")
     * @ParamConverter("user", options={"mapping": {"idUser" : "id"}})
     * @ParamConverter("character", options={"mapping": {"idCharacter" : "id"}})
    */
    public function deleteCharacter(ManagerRegistry $doctrine, User $user, Character $character): Response
    {
        if($this -> getUser() && $this -> getUser() == $character -> getUser()){

            $entityManager = $doctrine->getManager(); 
            $entityManager->remove($character);
            $entityManager->flush();
    
            return $this->redirectToRoute('profil_user', ['id'=>$user->getId()]);

        } else {

            return $this -> redirectToRoute('app_home');
        }
    
    }




     // ! il est préférable de mettre cette fonction à la fin pour pas qu'elle rentre en conflit avec les autres (à cause de la route "/{id}")
    /**
     * @Route("/userProfil/{id}", name="profil_user")
     */
    public function profil(ManagerRegistry $doctrine, User $user): Response
    {
        $servers = $doctrine->getRepository(Server::class)->findBy([], ["serverName" => "ASC"]);
        
        return $this->render('user/profil.html.twig', [
            'servers' =>$servers,
            'user' => $user
        ]);
    }

    /**
     * @Route("/userAccount/{id}", name="account_user")
     */
    public function account(User $user): Response
    {
        return $this->render('user/account.html.twig', [
            'user' => $user
        ]);
    }

}
