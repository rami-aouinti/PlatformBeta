<?php

namespace App\Controller;

use App\Entity\Timework;
use App\Form\TimeworkType;
use App\Repository\TimeworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/timework')]
class TimeworkController extends AbstractController
{
    #[Route('/', name: 'timework_index', methods: ['GET'])]
    public function index(TimeworkRepository $timeworkRepository): Response
    {
        return $this->render('timework/index.html.twig', [
            'timeworks' => $timeworkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'timework_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $timework = new Timework();
        $form = $this->createForm(TimeworkType::class, $timework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($timework);
            $entityManager->flush();

            return $this->redirectToRoute('timework_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('timework/new.html.twig', [
            'timework' => $timework,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'timework_show', methods: ['GET'])]
    public function show(Timework $timework): Response
    {
        return $this->render('timework/show.html.twig', [
            'timework' => $timework,
        ]);
    }

    #[Route('/{id}/edit', name: 'timework_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Timework $timework, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TimeworkType::class, $timework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('timework_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('timework/edit.html.twig', [
            'timework' => $timework,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'timework_delete', methods: ['POST'])]
    public function delete(Request $request, Timework $timework, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$timework->getId(), $request->request->get('_token'))) {
            $entityManager->remove($timework);
            $entityManager->flush();
        }

        return $this->redirectToRoute('timework_index', [], Response::HTTP_SEE_OTHER);
    }
}
