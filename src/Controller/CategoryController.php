<?php

namespace App\Controller;

use App\Service\posts;
use App\Service\Sign_up;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{name}', name: 'app_category')]
    public function index(Sign_up $sign_up, posts $posts, $name): Response
    {
        return $this->render('category/index.html.twig', ['posts' => $posts->getPostsByCat($name)]);

    }
}