<?php

namespace App\Controller;

use App\Entity\TraductionSource;
use App\Form\TraductionSourceType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TraductionSourceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/traduction/source')]
class TraductionSourceController extends AbstractController
{
    // #[Route('/', name: 'traduction_source_index', methods: ['GET'])]
    // public function index(TraductionSourceRepository $traductionSourceRepository): Response
    // {
    //     return $this->render('traduction_source/index.html.twig', [
    //         'traduction_sources' => $traductionSourceRepository->findAll(),
    //     ]);
    // }

    #[Route('/project/{id}', name: 'traduction_source_byproject', methods: ['GET'])]
    public function showListByProject(TraductionSourceRepository $traductionSourceRepository, int $id): Response
    {
        return $this->render('traduction_source/index.html.twig', [
            'traduction_sources' => $traductionSourceRepository->findBy(array('project' => $id)),
            'projectId' => $id,
        ]);
    }

    #[Route('/project/{id}/new', name: 'traduction_source_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ProjectRepository $projectRepository, int $id): Response
    {
        //Get the project object which we want to add a source 
        $project = $projectRepository->find($id);

        $traductionSource = new TraductionSource();
        $form = $this->createForm(TraductionSourceType::class, $traductionSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Set the project of the source by default
            $traductionSource->setProject($project);

            $entityManager->persist($traductionSource);
            $entityManager->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('traduction_source/new.html.twig', [
            'traduction_source' => $traductionSource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'traduction_source_show', methods: ['GET'])]
    public function show(TraductionSource $traductionSource): Response
    {
        return $this->render('traduction_source/show.html.twig', [
            'traduction_source' => $traductionSource,
        ]);
    }

    #[Route('/{id}/edit', name: 'traduction_source_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TraductionSource $traductionSource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TraductionSourceType::class, $traductionSource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('traduction_source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('traduction_source/edit.html.twig', [
            'traduction_source' => $traductionSource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'traduction_source_delete', methods: ['POST'])]
    public function delete(Request $request, TraductionSource $traductionSource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$traductionSource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($traductionSource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('traduction_source_index', [], Response::HTTP_SEE_OTHER);
    }
}
