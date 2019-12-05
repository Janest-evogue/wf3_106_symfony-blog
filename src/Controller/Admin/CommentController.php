<?php


namespace App\Controller\Admin;


use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Controller\Admin
 *
 * @Route("/commentaire")
 */
class CommentController extends AbstractController
{
    /**
     * L'id de l'article dont on veut voir les commentaires
     * @Route("/{id}")
     */
    public function index(Article $article)
    {
        return $this->render(
            'admin/comment/index.html.twig',
            [
                'article' => $article
            ]
        );
    }

    /**
     * @Route("/suppression/{id}")
     */
    public function delete(EntityManagerInterface $manager, Comment $comment)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash('success', 'Le commentaire est supprimé');

        return $this->redirectToRoute(
            'app_admin_comment_index',
            [
                'id' => $comment->getArticle()->getId()
            ]
        );
    }
}
