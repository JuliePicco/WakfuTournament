<?php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $tournaments = $doctrine->getRepository(Tournament::class)->findBy([], ["startDate" => "ASC"]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tournaments' => $tournaments
        ]);
    }
}
