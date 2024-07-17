<?php

namespace App\Controller\Admin;

use App\Entity\Candy;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/article', 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/article/index.html.twig');
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em): Response
    {
        $candy = new Candy();
        $candy->setName('fraise')
            ->setSlug('fraise')
            ->setDescription('Un super bonbon')
            ->setCreateAt(new DateTimeImmutable());

        $em->persist($candy);
        $em->flush();

        return $this->render('admin/article/create.html.twig');
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS])]
    public function update($id, CandyRepository $repository, EntityManagerInterface $em): Response
    {
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

        // Récupérer l'objet qui contient ce qui est tapé dans l'url
        $candy = $repository->find($id);
        $candy->setName('Fraise tagada');
        $em->flush();

        return $this->render('admin/article/update.html.twig');
    }

    #[Route('/delete/{id}/', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete($id, CandyRepository $repository, EntityManagerInterface $em, Candy $candy): Response
    {
        $em->remove($candy);
        $em->flush();

        return $this->render('admin/article/delete.html.twig');
    }
}
