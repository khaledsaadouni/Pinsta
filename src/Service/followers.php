<?php

namespace App\Service;

use App\Entity\Follow;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;

class followers
{
    private ManagerRegistry $doct;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doct = $doctrine;
    }

    public function getFollowers($id): array
    {
        $repo = $this->doct->getRepository(User::class);
        $c = $repo->findOneBy(['id' => $id]);
        $repos = $this->doct->getRepository(Follow::class);
        return $repos->findBy(['account' => $c]);


    }

    public function getFollowing($id): array
    {
        $repo = $this->doct->getRepository(User::class);
        $c = $repo->findOneBy(['id' => $id]);
        $repos = $this->doct->getRepository(Follow::class);
        return $repos->findBy(['following' => $c]);


    }

    public function fforf($id1, $id2): Boolean
    {
        $repo = $this->doct->getRepository(User::class);
        $c1 = $repo->findOneBy(['id' => $id1]);
        $repo = $this->doct->getRepository(User::class);
        $c2 = $repo->findOneBy(['id' => $id2]);
        $repos = $this->doct->getRepository(Follow::class);
        if ($repos->findBy(['account' => $c1, 'following' => $c2]))
            return true;
        return false;
    }

    public function addfollow($id1, $id2): void
    {
        $repo = $this->doct->getRepository(User::class);
        $c1 = $repo->findOneBy(['id' => $id1]);
        $repo = $this->doct->getRepository(User::class);
        $c2 = $repo->findOneBy(['id' => $id2]);
        $manager = $this->doct->getManager();
        $f = new Follow();
        $f->setAccount($c1);
        $f->setFollowing($c2);
        $manager->persist($f);
        $manager->flush();

    }

    public function unfollow($id1, $id2): void
    {
        $repo = $this->doct->getRepository(User::class);
        $c1 = $repo->findOneBy(['id' => $id1]);
        $repo = $this->doct->getRepository(User::class);
        $c2 = $repo->findOneBy(['id' => $id2]);
        $repos = $this->doct->getRepository(Follow::class);
        $follow = $repos->findOneBy(['account' => $c1, 'following' => $c2]);
        $manager = $this->doct->getManager();
        $manager->remove($follow);
        $manager->flush();

    }
}