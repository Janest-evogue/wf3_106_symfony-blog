<?php

namespace App\Controller;

use App\Entity\Category;
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
    public function index(Category $category)
    {
        /*
         * Lister les 2/3 derniers articles en date de la catégorie
         * avec un lien vers une page article à créer dans un nouveau contrôleur
         * qui affiche le détail de l'article avec son image s'il en a une
         */

        return $this->render(
            'category/index.html.twig',
            [
                'category' => $category,
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
