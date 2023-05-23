<?php

namespace App\Controller;

use App\Entity\StatusTaches;
use App\Entity\Taches;
use App\Form\TachesType;
use App\Repository\TachesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class TachesController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/', name: 'app_taches_index', methods: ['GET'])]
    public function index(TachesRepository $tachesRepository): Response
    {
        return $this->render('taches/index.html.twig', [
            'taches' => $tachesRepository->findAll(),
        ]);
    }

    #[Route('/taches/new', name: 'app_taches_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TachesRepository $tachesRepository): Response
    {
        $tach = new Taches();
        $form = $this->createForm(TachesType::class, $tach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('message', 'Votre tache a été ajouter avec succes');
            $status = $this->em->find(StatusTaches::class, 1);
            $tach->setStatus($status);
            $tachesRepository->save($tach, true);

            return $this->redirectToRoute('app_taches_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('taches/new.html.twig', [
            'tach' => $tach,
            'form' => $form,
        ]);
    }

    #[Route('/taches/{id}', name: 'app_taches_show', methods: ['GET'])]
    public function show(Taches $tach): Response
    {
        return $this->render('taches/show.html.twig', [
            'tach' => $tach,
        ]);
    }

    #[Route('/taches/{id}/edit', name: 'app_taches_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Taches $tach, TachesRepository $tachesRepository): Response
    {
        $form = $this->createForm(TachesType::class, $tach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('message', 'Votre tache a été ajouter avec succes');
            $tachesRepository->save($tach, true);
            return $this->redirectToRoute('app_taches_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('taches/edit.html.twig', [
            'tach' => $tach,
            'form' => $form,
        ]);
    }

    #[Route('/taches/{id}', name: 'app_taches_delete', methods: ['POST'])]
    public function delete(Request $request, Taches $tach, TachesRepository $tachesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tach->getId(), $request->request->get('_token'))) {
            $tachesRepository->remove($tach, true);
        }

        return $this->redirectToRoute('app_taches_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/status/taches', name: 'app_taches_status', methods: ['POST'])]
    public function status(Request $req)
    {
        $data = $req->getContent();
        $json = json_decode($data, true);
        $tache = $this->em->find(Taches::class, $json['tache']);
        if ($tache->getStatus()->getId() == 1) {
            $tache->setStatus($this->em->find(StatusTaches::class, 2));
        } else {
            $tache->setStatus($this->em->find(StatusTaches::class, 1));
        }
        $this->em->getRepository(Taches::class)->save($tache, true);
        $this->addFlash('message', 'Votre tache a été mise à jour');
        return $this->json(['save']);
    }
}
