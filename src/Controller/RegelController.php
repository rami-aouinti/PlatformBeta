<?php

namespace App\Controller;

use App\Entity\Regel;
use App\Form\RegelType;
use App\Repository\RegelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/regel')]
class RegelController extends AbstractController
{
    #[Route('/', name: 'regel_index', methods: ['GET'])]
    public function index(RegelRepository $regelRepository,
                          PaginatorInterface $paginator,
                          Request $request): Response
    {
        return $this->render('regel/index.html.twig', [
            'regels' => $regelRepository->listAll($paginator, $request),
        ]);
    }

    #[Route('/new', name: 'regel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $regel = new Regel();
        $form = $this->createForm(RegelType::class, $regel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($regel);
            $entityManager->flush();

            return $this->redirectToRoute('regel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('regel/new.html.twig', [
            'regel' => $regel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'regel_show', methods: ['GET'])]
    public function show(Regel $regel): Response
    {
        return $this->render('regel/show.html.twig', [
            'regel' => $regel,
        ]);
    }

    #[Route('/{id}/edit', name: 'regel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Regel $regel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegelType::class, $regel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('regel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('regel/edit.html.twig', [
            'regel' => $regel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'regel_delete', methods: ['POST'])]
    public function delete(Request $request, Regel $regel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$regel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($regel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('regel_index', [], Response::HTTP_SEE_OTHER);
    }
}
