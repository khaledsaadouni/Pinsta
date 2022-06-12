<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Sign_up extends AbstractController
{
    private AuthenticationUtils $auth;

    private EntityManagerInterface $manager;

    public function __construct(AuthenticationUtils $auth, EntityManagerInterface $m)
    {
        $this->auth = $auth;

        $this->manager = $m;
    }


}