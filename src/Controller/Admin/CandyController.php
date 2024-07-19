<?php

namespace App\Controller\Admin;

use App\Entity\Candy;
use App\Form\CandyType;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/article', 'admin_article_')]
class CandyController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CandyRepository $repository): Response
    {
        $candies = $repository->findAll();

        return $this->render('admin/article/index.html.twig', [
            'candies' => $candies
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $candy = new Candy();
        $form = $this->createForm(CandyType::class, $candy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candy->setCreateAt(new DateTimeImmutable());

            $slug = strtolower($candy->getName());
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($slug);
            $candy->setSlug($slug);

            $em->persist($candy);
            $em->flush();

            $this->addFlash('success', 'Votre bonbon a bien été créé');
            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('admin/article/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update(EntityManagerInterface $em, Candy $candy, Request $request): Response
    {
        $form = $this->createForm(CandyType::class, $candy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $this->addFlash('success', 'Votre bonbon a bien été modifié');
            return $this->redirectToRoute('admin_article_index');
        }
        // `find()` permet de recuperer un enregistrement de la base de données grâce à son id
        // $candy = $repository->find(1);

        //  `findAll()` permet de recuperer tous les enregistrement de la base de données
        // $candy = $repository->findAll();

        //  `findBy()` permet de recuperer tous les enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy = $repository->findBy(['name' => 'fraise']);

        //  `findOneBy()` permet de recuperer un enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy = $repository->findOneBy([
        //     'slug' => 'fraise',
        //     'name' => 'fraise'
        // ]);



        return $this->render('admin/article/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete/{id}/', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete($id, CandyRepository $repository, EntityManagerInterface $em, Candy $candy): Response
    {
        $em->remove($candy);
        $em->flush();

        return $this->render('admin/article/delete.html.twig');
    }
}
