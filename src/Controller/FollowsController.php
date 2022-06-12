<?php

namespace App\Controller;

use App\Service\followers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowsController extends AbstractController
{
    #[Route('/follow/{id}', name: 'app_follow')]
    public function follow($id, followers $followers): Response
    {
        $followers->addfollow($this->getUser()->getId(), $id);
        return $this->redirectToRoute('app_profil', ['id' => $id]);
    }

    #[Route('/unfollows/{id}', name: 'app_unfollows')]
    public function unfollows($id, followers $followers): Response
    {
        $followers->unfollow($this->getUser()->getId(), $id);
        return $this->redirectToRoute('app_profil', ['id' => $this->getUser()->getId()]);
    }

    #[Route('/unfollow/{id}', name: 'app_unfollow')]
    public function unfollow($id, followers $followers): Response
    {
        $followers->unfollow($this->getUser()->getId(), $id);
        return $this->redirectToRoute('app_profil', ['id' => $id]);
    }
}
