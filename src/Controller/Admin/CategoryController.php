<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/create', name: 'create', methods: ['POST','GET'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $categorie = new Category();
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $categorie->setCreateAt(new DateTimeImmutable());
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Une nouvelle categorie a bien été créé!');
            $this->addFlash('success', 'un autre message');

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/create.html.twig', [
            'formCategory' => $form
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $category->setUpdateAt(new DateTimeImmutable());

            $this->em->flush();
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/update.html.twig', [
            'formCategory' => $form
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Category $category)
    {
        $this->em->remove($category);
        $this->em->flush();

        return $this->redirectToRoute('admin_category_index');
    }
}
