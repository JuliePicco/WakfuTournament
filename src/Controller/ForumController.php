<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ForumController extends AbstractController
{
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


    
    // ! il est préférable de mettre cette fonction à la fin pour pas qu'elle rentre en conflit avec les autres (à cause de la route "/{id}")
    /**
     * @Route("/subCategory/{id}", name="subCategory")
    
     */
    public function subCategoryList(SubCategory $subCategory): Response
    {               
       
        return $this->render('forum/subCategory.html.twig', [
            'subCategory' => $subCategory,  
                 
        ]);
    }

    /**
     * @Route("/topic/{id}", name="topic")
     */
    public function topic(ManagerRegistry $doctrine, Topic $topic): Response
    {             
       
        
        return $this->render('forum/topic.html.twig', [
            'topic' => $topic, 
           
        ]);
    }


}
