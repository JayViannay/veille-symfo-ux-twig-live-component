<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $blog = new Blog();
            $blog
                ->setTitle($faker->sentence)
                ->setContent($faker->paragraph);

            $manager->persist($blog);
        }

        $manager->flush();
    }
}
