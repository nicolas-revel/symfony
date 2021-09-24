<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route ("/post/{slug}", name="show")
     * @param string $slug
     * @param Request $request
     * @return Response
     */
    public function show(string $slug, Request $request): Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['slug' => $slug]);
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Comment $comment */
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $comment = $form->getData();
            $comment->setCreatedAt(new DateTime());
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('post/show.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
            'commentform' => $form->createView(),
        ]);
    }
}
