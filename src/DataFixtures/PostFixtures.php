<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $slugger = new Slugify();
        $author = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@admin.fr']);
        $faker = Factory::create('fr-FR');
        for ($i = 0; $i < 80; $i++) {
            $post = new Post();
            $post->setTitle($faker->words(3, true));
            $post->setAuthor($author);
            $post->setContent($faker->realText(2000));
            $post->setSlug($slugger->slugify($post->getTitle()));
            $post->setImageName($faker->imageUrl());
            $post->setCreatedAt($faker->dateTime());
            $manager->persist($post);
        }

        $manager->flush();
    }


    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
