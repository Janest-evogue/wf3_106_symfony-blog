<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 *
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function index(Article $article)
    {
        /*
         * Sous l'article, si l'utilisateur n'est pas connecté,
         * l'inviter à le faire pour pouvoir écrire un commentaire.
         * Sinon, lui afficher un formulaire avec un textarea
         * pour pouvoir écrire un commentaire.
         * Nécessite une entité Comment avec :
         * - content (text en bdd)
         * - publicationDate (datetime)
         * - user (l'utilisateur qui écrit le commentaire)
         * - article (l'article sur lequel on écrit le commentaire)
         * Nécessite le form type qui va avec contenant le textarea,
         * le contenu du commentaire ne doit pas être vide.
         *
         * Lister les commentaires en dessous, avec nom utilisateur,
         * date de publication, contenu du message
         */

        return $this->render(
            'article/index.html.twig',
            [
                'article' => $article
            ]
        );
    }
}
