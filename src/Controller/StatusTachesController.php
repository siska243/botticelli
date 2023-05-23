<?php

namespace App\Controller;

use App\Entity\StatusTaches;
use App\Form\StatusTachesType;
use App\Repository\StatusTachesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/status/taches')]
class StatusTachesController extends AbstractController
{
    #[Route('/', name: 'app_status_taches_index', methods: ['GET'])]
    public function index(StatusTachesRepository $statusTachesRepository): Response
    {
        return $this->render('status_taches/index.html.twig', [
            'status_taches' => $statusTachesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_status_taches_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatusTachesRepository $statusTachesRepository): Response
    {
        $statusTach = new StatusTaches();
        $form = $this->createForm(StatusTachesType::class, $statusTach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statusTachesRepository->save($statusTach, true);

            return $this->redirectToRoute('app_status_taches_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status_taches/new.html.twig', [
            'status_tach' => $statusTach,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_status_taches_show', methods: ['GET'])]
    public function show(StatusTaches $statusTach): Response
    {
        return $this->render('status_taches/show.html.twig', [
            'status_tach' => $statusTach,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_status_taches_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StatusTaches $statusTach, StatusTachesRepository $statusTachesRepository): Response
    {
        $form = $this->createForm(StatusTachesType::class, $statusTach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statusTachesRepository->save($statusTach, true);

            return $this->redirectToRoute('app_status_taches_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status_taches/edit.html.twig', [
            'status_tach' => $statusTach,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_status_taches_delete', methods: ['POST'])]
    public function delete(Request $request, StatusTaches $statusTach, StatusTachesRepository $statusTachesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statusTach->getId(), $request->request->get('_token'))) {
            $statusTachesRepository->remove($statusTach, true);
        }

        return $this->redirectToRoute('app_status_taches_index', [], Response::HTTP_SEE_OTHER);
    }
}
