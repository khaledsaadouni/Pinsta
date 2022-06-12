<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->hasher = $encoder;
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

    public function load(ObjectManager $manager): void
    {
        $u = new User();
        $u->setUsername('khaled');
        $u->setEmail('khaled@gmail.com');
        $u->setName('saadouni');
        $u->setFirstname('khaled');
        $u->setPassword($this->hasher->hashPassword($u, "khaled"));
        $u->setCountry("Tunisia");
        $u->setPdp('av.png');

        $u->setCoverIm('cover.png');

        $manager->persist($u);

        $manager->flush();
    }
}
