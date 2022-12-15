<?php

namespace App\Controller;

use App\Entity\Topic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    /**
     * @Route("/lockTopic/{id}", name="lockTopic")
     */
    public function lockTopic(ManagerRegistry $doctrine): Response
    {
        $topic = $doctrine->getRepository(Topic::class)->findOneBy($id);
    
        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
        ]);
    }

    /**
     * @Route("/unlockTopic/{id}", name="unlockTopic")
     */
    public function unlockTopic(): Response
    {
        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
        ]);
    }
}
