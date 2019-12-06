<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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

    /**
     * @link https://symfony.com/doc/4.4/mailer.html
     * Voir le fichier .env pour la connexion à la boîte mail d'envoi
     *
     * @Route("/contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        // pré-remplissage des champs s'il y a un utilisateur connecté
        if (!is_null($this->getUser())) {
            $form->get('name')->setData($this->getUser());
            $form->get('email')->setData($this->getUser()->getEmail());
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();

                $mail = new Email();

                $mailBody = $this->renderView(
                    'index/contact_body.html.twig',
                    [
                        'data' => $data
                    ]
                );

                $mail
                    ->subject('Nouveau message sur votre blog')
                    ->from('janest.demo@gmail.com')
                    ->to('julien.anest@evogue.fr')
                    ->html($mailBody)
                    ->replyTo($data['email'])
                ;

                $mailer->send($mail);

                $this->addFlash('success', 'Votre message est envoyé');

                return $this->redirectToRoute($request->get('_route'));

            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'index/contact.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
