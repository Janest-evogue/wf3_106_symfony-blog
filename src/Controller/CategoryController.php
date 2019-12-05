<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 *
 * @Route("/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function index(ArticleRepository $articleRepository, Category $category)
    {
        /*
         * Lister les 2/3 derniers articles en date de la catégorie
         * avec un lien vers une page article à créer dans un nouveau contrôleur
         * qui affiche le détail de l'article avec son image s'il en a une
         */
        $articles = $articleRepository->findBy(
            ['category' => $category],
            ['publicationDate' => 'DESC'],
            3
        );

        return $this->render(
            'category/index.html.twig',
            [
                'category' => $category,
                'articles' => $articles
            ]
        );
    }

    public function menu(CategoryRepository $repository)
    {
        $categories = $repository->findBy([], ['name' => 'ASC']);

        return $this->render(
            'category/menu.html.twig',
            [
                'categories' => $categories
            ]
        );
    }
}
