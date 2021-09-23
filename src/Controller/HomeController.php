<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class HomeController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * @param PostRepository $postRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(PostRepository $postRepository, PaginatorInterface $paginator)
    {
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $unpaginatedPosts = $this->postRepository->getPaginatedPosts();
        $posts = $this->paginator->paginate($unpaginatedPosts, $request->query->getInt('page', 1), 15);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $posts,
        ]);
    }
}
