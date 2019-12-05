<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * Page d'accueil du site
     *
     * @Route("/")
     */
    public function index(ArticleRepository $articleRepository)
    {
        // les 5 derniers articles du blog
        $articles = $articleRepository->findBy(
            [],
            ['publicationDate' => 'DESC'],
            5
        );

        return $this->render(
            'index/index.html.twig',
            [
                'articles' => $articles
            ]
        );
    }
}
