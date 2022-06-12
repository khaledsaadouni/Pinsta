<?php

namespace App\Controller;

use App\Service\followers;
use App\Service\profil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil')]
    public function index(profil $p, $id, followers $followers): Response
    {
        if ($this->getUser()) {
            return $this->render('profil/index.html.twig', ['profil' => $p->getprofilid($id), 'post' => $p->getprofilpost($id), 'following' => $followers->getFollowers($id), 'follower' => $followers->getFollowing($id), 'fforf' => $followers->fforf($this->getUser()->getId(), $id)]);

        }
        return $this->render('profil/index.html.twig', ['profil' => $p->getprofilid($id), 'post' => $p->getprofilpost($id), 'following' => $followers->getFollowers($id), 'follower' => $followers->getFollowing($id)]);
    }
}
