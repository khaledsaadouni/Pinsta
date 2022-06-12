<?php

namespace App\Controller;

use App\Form\SignType;
use App\Service\profil;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class SettingsController extends AbstractController
{
    #[Route('/setting/{id}', name: 'app_setting')]
    public function index(Request $req,ManagerRegistry $doctrine,$id,profil $profil,SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $manager=$doctrine->getManager();
        $u=$profil->getprofilid($id);
        $form=$this->createForm(SignType::class,$u);
        $form->remove('Password');
        $form->remove('confirm_password');
        $form->handleRequest($req);
        if($form->isSubmitted())
        {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('Profile_Picture')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }



                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $u->setPdp($newFilename);
            }



            /** @var UploadedFile $File */
            $File = $form->get('Cover_Picture')->getData();
            if ($File) {
                $originalFile = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFile = $slugger->slug($originalFile);
                $newFile= $safeFile.'-'.uniqid().'.'.$File->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $File->move(
                        $this->getParameter('cover_directory'),
                        $newFile
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }



                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $u->setCoverIm($newFile);
            }



            $manager->persist($u);
            $manager->flush();
            return  $this->redirectToRoute('app_profil',['id'=>$u->getId()]);
        }
        return $this->render('settings/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/setting/{id}/reset_pwd', name: 'app_reset')]
    public function password(Request $req,ManagerRegistry $doctrine,$id,profil $profil,SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $manager=$doctrine->getManager();
        $u=$profil->getprofilid($id);
        $form=$this->createForm(SignType::class,$u);
        $form->remove('Username');
        $form->remove('Email');
        $form->remove('Country');
        $form->remove('Name');
        $form->remove('Firstname');
        $form->handleRequest($req);
        if($form->isSubmitted())
        {
            $u->setPassword(
                $userPasswordHasher->hashPassword(
                    $u,
                    $form->get('Password')->getData()
                )
            );
            $manager->persist($u);
            $manager->flush();
            return  $this->redirectToRoute('app_profil',['id'=>$u->getId()]);
        }

        return $this->render('settings/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
