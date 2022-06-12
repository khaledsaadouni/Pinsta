<?php

namespace App\Controller;

use App\Service\profil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DeleteAccountController extends AbstractController
{


    #[Route('/delete', name: 'app_delete_account')]
    public function index(profil                $profil, Request $request, EventDispatcherInterface $eventDispatcher,
                          TokenStorageInterface $tokenStorage): Response
    {
        $u = $this->getUser();
        $logoutEvent = new LogoutEvent($request, $tokenStorage->getToken());
        $eventDispatcher->dispatch($logoutEvent);
        $tokenStorage->setToken(null);

        $profil->delete($u);


        return $this->redirect($this->generateUrl('app_home'));
    }

    #[Route('/confirm', name: 'app_confirm')]
    public function confirm(): Response
    {
        return $this->render('delete_account/index.html.twig', [

        ]);
    }

}
