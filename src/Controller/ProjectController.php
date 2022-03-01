<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
class ProjectController extends AbstractController
{
    // #[Route('/', name: 'project_index', methods: ['GET'])]
    // public function index(ProjectRepository $projectRepository): Response
    // {
    //     return $this->render('project/index.html.twig', [
    //         'projects' => $projectRepository->findAll(),
    //     ]);
    // }

    #[Route('/', name: 'project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository, UserRepository $userRepository): Response
    {
        //Get id of user connected to get his projects
        $user = $userRepository->find($this->getUser());
        $userId = $user->getId();

        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findBy(array('user' => $userId)),
        ]);
    }

    #[Route('/new', name: 'project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get username of user connected
        $user = $this->getUser();

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Default field (is_deleted: no, block_source: yes, dateTime)
            $project->setIsDeleted(0)->setBlockSources(1)->setDateAdd(new \DateTime())->setUser($user);
             //Username of user connected
            $entityManager->persist($project);

            $entityManager->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Project updated');

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
    }
}
