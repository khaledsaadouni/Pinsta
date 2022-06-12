<?php

namespace App\Service;

use App\Entity\Liking;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class likes
{
    private ManagerRegistry $doct;
    private $manager;
    private posts $posts;
    private profil $profil;

    public function __construct(ManagerRegistry $doctrine, profil $profil, posts $posts)
    {
        $this->doct = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->profil = $profil;
        $this->posts = $posts;
    }


    public function getLikes($id)
    {
        $ps = $this->posts->getPostsById($id);
        $repo = $this->doct->getRepository(Liking::class);
        return $repo->findBy(['Post' => $ps]);

    }

    public function addLike($id, $user)

    {
        $ps = $this->posts->getPostsById($id);
        $l = new Liking();
        $l->setUser($user);
        $l->setPost($ps);
        $this->manager->persist($l);
        $this->manager->flush();


    }

    public function check($id, User $user)
    {

        $ps = $this->posts->getPostsById($id);
        $repo = $this->doct->getRepository(Liking::class);
        if ($repo->findBy(['Post' => $ps, 'User' => $user])) {
            return true;
        }
    }

    public function unlike($id, User $user)
    {

        $ps = $this->posts->getPostsById($id);
        $repo = $this->doct->getRepository(Liking::class)->findOneBy(['Post' => $ps, 'User' => $user]);
        $this->manager->remove($repo);
        $this->manager->flush();
    }


}