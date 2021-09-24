<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param PostRepository $postRepository
     * @param UserRepository $userRepository
     */
    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $posts = $this->postRepository->findAll();
        $user = $this->userRepository->findAll();
        for ($i = 0; $i < 180; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->realText(200));
            $comment->setAuthor($user[$faker->numberBetween(0, 30)]);
            $comment->setPost($posts[$faker->numberBetween(0, 79)]);
            $comment->setCreatedAt($faker->dateTime());
            $manager->persist($comment);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PostFixtures::class,
        ];
    }
}
