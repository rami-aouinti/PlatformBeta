<?php

namespace App\Controller;

use App\Entity\Timework;
use App\Form\TimeworkType;
use App\Repository\TimeworkRepository;
use App\Services\FlashMessage;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/timework')]
class TimeworkController extends AbstractController
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var TranslatorInterface
     */
    private $trans;

    /**
     * @param Security $security
     */
    public function __construct(Security $security, TranslatorInterface $trans)
    {
        $this->security = $security;
        $this->trans = $trans;
    }

    #[Route('/', name: 'timework_index', methods: ['GET', 'POST'])]
    public function index(
        TimeworkRepository $timeworkRepository,
        PaginatorInterface $paginator,
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security,
        FlashMessage $flashMessage
    ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $security->getUser();
        $timework = new Timework();
        $timework->setUser($user);
        $form = $this->createForm(TimeworkType::class, $timework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($timework);
            $entityManager->flush();
            $flashMessage->createMessage(
                $request,
                FlashMessage::INFO_MESSAGE,
                $this->trans->trans('backoffice.timework.flashmessage_publish'));
            return $this->redirectToRoute('timework_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('timework/index.html.twig', [
            'timeworks' => $timeworkRepository->listAll($paginator, $request),
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'timework_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('timework/show.html.twig', [
            'timework' => $timework,
        ]);
    }

    #[Route('/{id}/edit', name: 'timework_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Timework $timework, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$timework->getId(), $request->request->get('_token'))) {
            $entityManager->remove($timework);
            $entityManager->flush();
        }

        return $this->redirectToRoute('timework_index', [], Response::HTTP_SEE_OTHER);
    }
}
