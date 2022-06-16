<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    #[Route('/search', name: 'app_search')]
    public function search(): Response
    {
        return $this->render('blog/search.html.twig');
    }

    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(Blog $blogpost): Response
    {
        return $this->render('blog/edit.html.twig', [
            'blogpost' => $blogpost,
        ]);
    }
}
