<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CatFixture extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['cat'];
    }

    public function load(ObjectManager $manager): void
    {
        $c = new Category();
        $c->setName("Lifestyle");
        $manager->persist($c);
        $c1 = new Category();
        $c1->setName("Food");
        $manager->persist($c1);
        $c2 = new Category();
        $c2->setName("Home");
        $manager->persist($c2);
        $c3 = new Category();
        $c3->setName("Travel");
        $manager->persist($c3);
        $c4 = new Category();
        $c4->setName("Astronomy");
        $manager->persist($c4);
        $c5 = new Category();
        $c5->setName("Nature");
        $manager->persist($c5);
        $c6 = new Category();
        $c6->setName("Cooking");
        $manager->persist($c6);
        $c7 = new Category();
        $c7->setName("Fashion");
        $manager->persist($c7);
        $c8 = new Category();
        $c8->setName("Cars");
        $manager->persist($c8);
        $manager->flush();
    }
}
