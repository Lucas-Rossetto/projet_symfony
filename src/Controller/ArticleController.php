<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        // Get The Doctrine Manager
        $em = $this->getDoctrine()->getManager();

        // Get all entities from Article table
        $articles = $em->getRepository(Article::class)->findAll();

        // Send to the View template 'article/register.html.twig' an array of content

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
        ]);
    }


}
