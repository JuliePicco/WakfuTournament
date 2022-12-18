<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Tournament;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {
        $tournaments = $doctrine->getRepository(Tournament::class)->findBy([], ["startDate" => "ASC"]);
        $news = $doctrine->getRepository(News::class)->findBy([], ["newsCreationDate" => "DESC"]);

        $news = $paginator->paginate(
            $news,
            $request->query->getInt( 'page',  1),
             6
        );

        return $this->render('home/index.html.twig', [
            'tournaments' => $tournaments,
            'news' => $news
        ]);
    }

     /**
     * @Route("/home/reglement-forum", name="app_reglement")
     */
    public function reglement(): Response
    {
        return $this->render('home/reglementForum.html.twig', [
            
        ]);
    }



    /**
     * @Route("/home/cgu", name="app_cgu")
     */
    public function cgu(): Response
    {
        return $this->render('home/cgu.html.twig', [
            
        ]);
    }


    /**
     * @Route("/home/politique-confidentialite", name="app_politique_confidentialite")
     */
    public function politiqueConfidentialite(): Response
    {
        return $this->render('home/politiqueConfi.html.twig', [
            
        ]);
    }

    /**
     * @Route("/home/contact", name="app_contact")
     */
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            
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
