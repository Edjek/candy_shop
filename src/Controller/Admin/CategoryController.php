<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em): Response
    {
        $category = new Category();
        $category->setName('test')
            ->setDescription('test')
            ->setCreateAt(new DateTimeImmutable());

        $em->persist($category);
        $em->flush();

        return $this->render('admin/category/create.html.twig');
    }
}
