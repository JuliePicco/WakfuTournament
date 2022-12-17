<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class TwitchController extends AbstractController
{

   /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/twitch", name="connect_twitch_start")
     */
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        /**@var twitchHelixClient $client */
        $client = $clientRegistry->getClient('twitch_helix');
       

        return $client->redirect(['user:read:email']);
    }

    /**
     * After going to Twitch, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/twitch/check", name="connect_twitch_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\TwitchHelixClient $client */
        $client = $clientRegistry->getClient('twitch_helix');
       
        try {
            // the exact class depends on which provider you're using
            /** @var Vertisan\OAuth2\Client\Provider\TwitchHelix $user */
            $user = $client->fetchUser();

            // do something with all this new power!
            // e.g. $name = $user->getFirstName();
            var_dump($user); die;
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage()); die;
        }
    }



}