<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add8Controller extends AbstractController
{
    #[Route('/add8', name: 'app_add8')]
    public function index(): Response
    {
        return $this->render('add8/index.html.twig', [
            'controller_name' => 'Add8Controller',
        ]);
    }
}
