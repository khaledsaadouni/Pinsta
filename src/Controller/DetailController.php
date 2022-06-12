<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Service\likes;
use App\Service\posts;
use App\Service\profil;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DetailController extends AbstractController
{
    #[Route('/post/{id}', name: 'app_post')]
    public function index(Request $req, ManagerRegistry $doctrine, posts $posts, $id, likes $likes): Response
    {
        $check = false;
        if ($this->getUser()) {
            $check = $likes->check($id, $this->getUser());
        }

        $c = new Comment();
        $form = $this->createForm(CommentType::class, $c);

        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            if ($this->getUser()) {
                $c->setPost($posts->getPostsById($id));
                $c->setAuthor($this->getUser());
                $doctrine->getManager()->persist($c);
                $doctrine->getManager()->flush();
            } else {
                return $this->redirectToRoute('app_login');
            }
        }
        if ($posts->getPostsById($id)->getCategory()) {
            return $this->render('detail/index.html.twig', ['post' => $posts->getPostsById($id), 'likes' => $likes->getLikes($id), 'check' => $check, 'comment' => $form->createView(), 'comments' => $posts->getComments($id), 'postCat' => $posts->getPostsByCat($posts->getPostsById($id)->getCategory()->getName())]);
        } else {
            return $this->render('detail/index.html.twig', ['post' => $posts->getPostsById($id), 'likes' => $likes->getLikes($id), 'check' => $check, 'comment' => $form->createView(), 'comments' => $posts->getComments($id), 'postCat' => Null]);

        }

    }

    #[Route('/newpost', name: 'app_new')]
    public function newindex(Request $req, ManagerRegistry $doctrine, profil $profil, SluggerInterface $slugger): Response
    {
        $manager = $doctrine->getManager();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            /** @var UploadedFile $picpost */
            $picpost = $form->get('Post')->getData();
            if ($picpost) {
                $originalFilename = pathinfo($picpost->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picpost->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picpost->move(
                        $this->getParameter('post_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }


                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setImageURL($newFilename);
            }
            $post->setAuthor($this->getUser());

            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('app_profil', ['id' => $this->getUser()->getId()]);
        }

        return $this->render('detail/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/post/like/{id}', name: 'app_like')]
    public function like(likes $likes, $id): Response
    {
        if ($this->getUser()) {
            $likes->addLike($id, $this->getUser());
        } else {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('app_post', ['id' => $id]);
    }

    #[Route('/post/unlike/{id}', name: 'app_unlike')]
    public function unlike(likes $likes, $id): Response
    {
        if ($this->getUser()) {
            $likes->unLike($id, $this->getUser());
        } else {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('app_post', ['id' => $id]);
    }

    #[Route('/post/uncomment/{id}/{us}', name: 'app_uncomment')]
    public function uncomment(posts $posts, $id, $us): Response
    {
        if ($this->getUser()) {
            $posts->uncomment($id, $us);

        } else {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('app_post', ['id' => $id]);
    }
}
