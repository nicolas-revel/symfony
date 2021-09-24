<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $user = new User();
        $user->setEmail('admin@admin.fr');
        $user->setPassword($this->hasher->hashPassword($user, 'admin'));
        $user->setUsername('admin');
        $user->setBirthDate(new DateTime('23-02-1996'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setCreatedAt(new DateTime());
        $manager->persist($user);
        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, $faker->password()));
            $user->setUsername($faker->userName());
            $user->setBirthDate($faker->dateTime());
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt($faker->dateTime());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
