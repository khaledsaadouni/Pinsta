<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Follow;
use App\Entity\Liking;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class profil
{
    private $doct;
    private $manager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doct = $doctrine;
        $this->manager = $doctrine->getManager();
    }

    public function getprofilid($id)
    {
        $repo = $this->doct->getRepository(User::class);
        $p = $repo->findOneBy(['id' => $id]);
        return $p;
    }

    public function getprofilpost($id)
    {
        $repo = $this->doct->getRepository(Post::class);
        $tab = $repo->findprofilordred($id);

        return $tab;
    }

    public function delete($user)
    {
        $repo = $this->doct->getRepository(Comment::class);
        $c1 = $repo->findBy(['author' => $user]);
        foreach ($c1 as $c) {
            $this->manager->remove($c);
        }
        $repo1 = $this->doct->getRepository(Post::class);
        $p1 = $repo1->findBy(['Author' => $user]);
        foreach ($p1 as $p) {
            $this->manager->remove($p);
        }
        $repo2 = $this->doct->getRepository(Follow::class);
        $f1 = $repo2->findBy(['account' => $user]);
        foreach ($f1 as $f) {
            $this->manager->remove($f);
        }
        $repo3 = $this->doct->getRepository(Follow::class);
        $g1 = $repo3->findBy(['following' => $user]);
        foreach ($g1 as $g) {
            $this->manager->remove($g);
        }
        $repo4 = $this->doct->getRepository(Liking::class);
        $l1 = $repo4->findBy(['User' => $user]);
        foreach ($l1 as $l) {
            $this->manager->remove($l);
        }

        $this->manager->remove($user);
        $this->manager->flush();
    }
}