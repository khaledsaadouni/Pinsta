<?php

namespace App\Service;


use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

class posts
{
    private $doct;
    private $manager;
    private $profil;

    public function __construct(ManagerRegistry $doctrine, profil $profil)
    {
        $this->doct = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->profil = $profil;
    }

    public function getPostsByCat($n)
    {
        $repo = $this->doct->getRepository(Category::class);
        $c = $repo->findOneBy(['name' => $n]);
        return $c->getPosts();
    }

    public function getPosts()
    {
        $repo = $this->doct->getRepository(Post::class);
        $tab = $repo->findOrdred();
        return $tab;
    }

    public function getComments($id)
    {
        $repo = $this->doct->getRepository(Comment::class);

        return $repo->findBy(['post' => $this->getPostsById($id)]);
    }

    public function getPostsById($id)
    {
        $repo = $this->doct->getRepository(Post::class);
        $tab = $repo->findOneBy(['id' => $id]);
        return $tab;
    }

    public function uncomment($id, $user)
    {
        $repo = $this->doct->getRepository(Comment::class);
        $c = $repo->findOneBy(['post' => $this->getPostsById($id), 'author' => $this->profil->getprofilid($user)]);
        $this->manager->remove($c);
        $this->manager->flush();
    }
}