<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfilType;
use App\Form\EditAccountType;
use Doctrine\Persistence\ManagerRegistry;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    //* MODIFICATION DU PROFIL

    /**
     * @Route("/security/editProfil", name="edit_profil")
     */
    public function editProfil(ManagerRegistry $doctrine, Request $request) : Response {

        // Vérifie qu'il y a un user en session
        if ($this->getUser()){

            //recupère l'user en session
            $user = $this->getUser();

            // Information spécifique qui auront des conditions par plus tard
             
            $pseudo = $user -> getPseudonyme(); 
            $email = $user -> getEmail();
            $discord = $user -> getDiscordPseudo();
            $twitch = $user ->getTwitchLink();
            $avatar = $user -> getAvatar();
    
            // Creation de formulaire
            $form =  $this->createForm(EditProfilType::class, $user);
            // gère la requête envoyée dans le formulaire
            $form->handleRequest($request); 
    
            if($form->isSubmitted()){
                if($form->isValid()){

                    // Recupération du nouveau pseudo saisi dans le formulaire
                    $newPseudo = $form->get('pseudonyme')->getData();
                    // Requete DQL dans le but de savoir si la nouvelle information existe deja en BDD ou non.
                    $verifyPseudo = $doctrine->getRepository(User::class)->findOneBy(['pseudonyme' => $newPseudo], []);
    
                    // Recupération du nouveau pseudo saisi dans le formulaire
                    $newEmail = $form->get('email')->getData();
                    // Requete DQL dans le but de savoir si la nouvelle information existe deja en BDD ou non.
                    $verifyEmail = $doctrine->getRepository(User::class)->findOneBy(['email' => $newEmail], []);
    
                    // Recupération de la nouvelle saisi dans le formulaire
                    $newDiscord = $form->get('discordPseudo')->getData();
                    // Requete DQL dans le but de savoir si la nouvelle information existe deja en BDD ou non.
                    $verifyDiscord = $doctrine->getRepository(User::class)->findOneBy(['discordPseudo' => $newDiscord], []);
    
                    // Recupération de la nouvelle saisi dans le formulaire
                    $newTwitch = $form->get('twitchLink')->getData();
                    // Requete DQL dans le but de savoir si la nouvelle information existe deja en BDD ou non.
                    $verifyTwitch = $doctrine->getRepository(User::class)->findOneBy(['twitchLink' => $newTwitch], []);

                    // Recupération de la nouvelle saisi dans le formulaire
                    $newAvatar = $form->get('avatar')->getData();
    
    
                    //  Si le nouveau pseudo est différent du pseudo actuel
                    if($newPseudo != $pseudo){
    
                        // et si le nouveau pseudo n'existe pas dans la BDD
                        if(!isset($verifyPseudo)){
    
    
                            // On accède à la BDD
                            $entityManager = $doctrine->getManager(); 
    
                            // On persiste/prepare l'objet
                            $entityManager->persist($user);
                            // On flush/execute ce qui a été demandé (ici le changement de pseudo)
                            $entityManager->flush();
    
    
                        } else {
    
                            $this->addFlash('warning', 'Pseudonyme déjà utilisé ! Veuillez en saisir un autre !');

                            // Cela permet d 'actualiser le profile sans avoir à subir un logout lorsqu'il y a une erreur 
                            $entityManager = $doctrine->getManager(); 
                            $entityManager->refresh($user);
    
                            // permet de rediriger vers la bonne vue (ici profile)
                            return $this->redirectToRoute('edit_profil',['id'=>$user->getId()]);
    
                        }
    
                    }
    
                    //  Si le nouveau email est différent de l'email actuel
                    if($newEmail != $email){
    
                        // et si le nouvel email n'existe pas dans la BDD
                        if(!isset($verifyEmail)){
    
                            // On accède à la BDD
                            $entityManager = $doctrine->getManager(); 
    
                            // On persiste/prepare l'objet
                            $entityManager->persist($user);
                            // On flush/execute ce qui a été demandé 
                            $entityManager->flush();
    
    
                        } else {
    
                            $this->addFlash('warning', 'Email déjà utilisé ! Veuillez en saisir un autre !');

                            // Cela permet d 'actualiser le profile sans avoir à subir un logout lorsqu'il y a une erreur 
                            $entityManager = $doctrine->getManager(); 
                            $entityManager->refresh($user);
    
                            // permet de rediriger vers la bonne vue (ici profile)
                            return $this->redirectToRoute('edit_profil',['id'=>$user->getId()]);
    
                        }
    
                    }
    
    
                    //  Si le nouveau discord est différent du discord actuel
                    if($newDiscord != $discord){
    
                        // et si le nouveau discord n'existe pas dans la BDD
                        if(!isset($verifyDiscord)){
    
    
                            // On accède à la BDD
                            $entityManager = $doctrine->getManager(); 
    
                            // On persiste/prepare l'objet
                            $entityManager->persist($user);
                            // On flush/execute ce qui a été demandé 
                            $entityManager->flush();
    
    
                        } else {
    
                            $this->addFlash('warning', 'Pseudonyme discord déjà utilisé ! Veuillez en saisir un autre !');

                            // Cela permet d 'actualiser le profile sans avoir à subir un logout lorsqu'il y a une erreur 
                            $entityManager = $doctrine->getManager(); 
                            $entityManager->refresh($user);
    
                            // permet de rediriger vers la bonne vue (ici profile)
                            return $this->redirectToRoute('edit_profil',['id'=>$user->getId()]);
    
                        }
    
                    }
    
    
                    //  Si le nouveau discord est différent du discord actuel
                    if($newTwitch != $twitch){
    
                        // et si le nouveau discord n'existe pas dans la BDD
                        if(!isset($verifyTwitch)){
    
    
                            // On accède à la BDD
                            $entityManager = $doctrine->getManager(); 
    
                            // On persiste/prepare l'objet
                            $entityManager->persist($user);
                            // On flush/execute ce qui a été demandé 
                            $entityManager->flush();
    
    
                        } else {
    
                            $this->addFlash('warning', 'Lien Twitch déjà utilisé ! Veuillez en saisir un autre !');

                            // Cela permet d 'actualiser le profile sans avoir à subir un logout lorsqu'il y a une erreur 
                            $entityManager = $doctrine->getManager(); 
                            $entityManager->refresh($user);
    
                            // permet de rediriger vers la bonne vue (ici profile)
                            return $this->redirectToRoute('edit_profil',['id'=>$user->getId()]);
    
                        }
                    
                    }
    
                    if($newAvatar != $avatar){
    
                        if(isset($newAvatar)){
    
                            // Permet de vérifier le format  utilisé d'une image et de voir s'il est autorisé.
                            if(in_array($newAvatar -> guessExtension(), ["png", "jpeg", "jpg", "webp" ])){
    
                                // Condition de la taille max autorisé (200ko)
                                if($newAvatar ->getSize() <= 204800){
    
                                    // md5 (Message Digest 5) => C'est un algorithme de hachage faible
                                    // uniqId => Génère un identifiant unique basé sur la date et l'heure courante 
    
                                    $file = md5(uniqid()) . '.' . $newAvatar -> guessExtension();
    
                                    // On déplace le fichier avatar de l'utilisateur dans son dossier avatarUser via le paramettre 'avatar_directory' situé dans le service.yaml
                                    $newAvatar -> move(
                                        $this -> getParameter('avatar_directory'),
                                        $file
                                    );
    
                                    // On récupère dans notre disque local l'avatar actuel avant sa modification par l'utilisateur. 
                                    // On passe donc par le getParameter('avatar_directory') pour le retrouver dans son fichier (avatar)
                                    // pour ce faire j'utilise de nouveau le getParameter('avatar_directory') pour localiser le fichier dans public/img/avatars 
                                    $avatarName = $this -> getParameter('avatar_directory'). '/' . $user -> getAvatar();
    
                                    if($avatarName != $this -> getParameter('avatar_directory') . '/profil-default.png'){
    
                                        // file_exists() => Permet de vérifier si "$avatarName" existe
                                        // unlink() => Permet de supprimer le fichier ou dossier qui sera remplacé
    
                                        if(file_exists($avatarName) ){
                                            unlink($avatarName);
                                        }
    
                                    }
                                    // Initialisation du nouvelle avatar
                                    $user -> setAvatar($file);
                                            
                                    // On accède à la BDD
                                    $entityManager = $doctrine->getManager(); 
    
                                    // On persiste/prepare l'objet
                                    $entityManager->persist($user);
                                    // On flush/execute ce qui a été demandé 
                                    $entityManager->flush();

                                } else {
                                    // erreur si le poid dépasse les 200ko
                                    $this -> addFlash('warning', "Votre avatar ne doit pas dépasser les 200Ko !");
                                }
                            }else {
                                // erreur si le format de l'avatar est mauvais
                                $this -> addFlash('warning', "Le format de votre avatar n'est pas supporté ! Format possible : png, jpeg, jpg et webp");
                            }
                        }
                    }
    
                    $this->addFlash('success', 'Votre profil a bien été mis à jour');
    
                    // permet de rediriger vers la bonne vue (ici profile)
                    return $this->redirectToRoute('profil_user', ['id'=>$user->getId()]);
                }
                
                // Cela permet d 'actualiser le profile sans avoir à subir un logout lorsqu'il y a une erreur 
                $entityManager = $doctrine->getManager(); 
                $entityManager->refresh($user);

            } 
           
                // Permet d'afficher le formulaire edit profil
                return $this->render('user/editProfil.html.twig', [
                'editProfilForm' => $form->createView(),
                'userId' => $user->getId()
            ]);
        
        } else {
            
            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this->redirectToRoute('app_home');
            
        } 

    }


    //* MODIFICATION DU MOT DE PASSE

    /**
     * @Route("/security/editPassword", name="edit_password")
     */

    public function editPassword(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher)
    {

        // On verifie si il y a un user en session
        if($this -> getUser()){

            // On récupère le user en session
            $user = $this->getUser();

            // Création d'un formulaire à partir des informations dans l'EditAccountType
            $form =  $this->createForm(EditAccountType::class, $user);
            // gère la requête envoyée dans le formulaire
            $form->handleRequest($request); 


            if($form -> isSubmitted() && $form -> isValid()){

                // On récupère le mot de passe hashé dans la base de donnée
                $passwordBDD = $user -> getPassword();

                // Mot de passe de l'utilisateur qui correspond au mot de passe hashé
                $password = $form -> get('actualPassword') -> getData();

                // On récupère le nouveau mot de passe saisi dans le formulaire
                $newPassword = $form->get('plainPassword')->getData();
                

                // password_verify => Permet de verifier que le hachage donné correspond au mot de passe donné.
                if(password_verify($password, $passwordBDD)){


                    // On récupère le setPassword dans notre objet user pour initialiser le mot de passe et on hash le nouveau password
                    $user -> setPassword($passwordHasher -> hashPassword($user,  $newPassword));

                     // On accède à la BDD
                    $entityManager = $doctrine->getManager(); 

                    // On flush/execute ce qui a été demandé (ici le changement de MDP)
                    $entityManager->flush();

                    // Message
                    $this -> addFlash("success", "Votre mot de passe a bien été modifié");

                    // redirection
                    return $this -> redirectToRoute('account_user', ['id'=>$user->getId()]);

                // Si le mot de passe saisi dans le formulaire n'est pas identique à celui de enregistrer en base de donnée on affiche un message
                } else {

                   $this -> addFlash("warning", "Votre mot de passe est incorect");

                   return $this -> redirectToRoute('edit_password', ['id'=>$user->getId()]);

                };

            }

            return $this->render('user/editPassword.html.twig', [
                'editAccountForm' => $form -> createView(),
                'userId' => $user->getId()
            ]);

        // S il n'y a pas d'utilisateur en session on le redirige vers la page d'acceuil du site
        } else {

            $this -> addFlash('danger', "Une erreur est survenue, veuillez réessayer !");
            return $this -> redirectToRoute('app_home');

        }

    }


    // * SUPPRESSION DU COMPTE

    /**
     * @Route("/security/deleteAccount", name="delete_account")
     */
    public function deleteAccount(ManagerRegistry $doctrine, Request $request)
    {
        // Si il existe un user en session
        if($this -> getUser()){

            $user = $this -> getUser();
            
           // On accède à la BDD
            $entityManager = $doctrine->getManager(); 

            // On persiste/prepare l'objet
            $entityManager->remove($user);
            // On flush/execute ce qui a été demandé (ici le changement de pseudo)
            $entityManager->flush();
    
            $request->getSession()->invalidate();
    
            $this->container->get('security.token_storage')->setToken(null);
    
            $this -> addFlash('success', "Votre compte a bien été supprimé !");
            
            return $this->redirectToRoute('app_register');

   
        }


    }
}
