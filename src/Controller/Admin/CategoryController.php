<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'index')]
    public function index(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(): Response
    {
        $category = new Category();
        $category->setName('test')
            ->setDescription('test')
            ->setCreateAt(new DateTimeImmutable());

        $this->em->persist($category);
        $this->em->flush();

        return $this->render('admin/category/create.html.twig');
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Category $category): Response
    {
        $category;
        $category->setName('modification');

        $this->em->flush();
        return $this->render('admin/category/update.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Category $category)
    {
        $this->em->remove($category);
        $this->em->flush();

        return $this->redirectToRoute('admin_category_index');
    }
}
