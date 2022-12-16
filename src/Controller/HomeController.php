<?php

namespace App\Controller;

use App\Entity\News;
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
        $news = $doctrine->getRepository(News::class)->findBy([], ["newsCreationDate" => "DESC"]);

        return $this->render('home/index.html.twig', [
            'tournaments' => $tournaments,
            'news' => $news
        ]);
    }


    /**
     * @Route("/home/news/{id}", name="show_news")
     */
    public function showNews(News $news): Response
    {
        return $this->render('home/news.html.twig', [
            'news' => $news
        ]);
    }
}
