<?php

namespace App\Controller;

use App\Service\posts;
use App\Service\Sign_up;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    public function index(Sign_up $sign_up, posts $posts): Response
    {

        return $this->render('home/index.html.twig', ['posts' => $posts->getPosts()]);
    }

    #[Route('/', name: 'app_h')]
    public function index2(): Response
    {
        return $this->redirectToRoute('app_home');
    }
}
