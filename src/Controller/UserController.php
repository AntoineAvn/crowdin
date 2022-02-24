<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\EditProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/profil', name: 'user_profil', methods: ['GET'])]
    public function profil(UserRepository $userRepository): Response
    {
        return $this->render('user/profil.html.twig', [
            'user' => $userRepository->find($this->getUser()),
        ]);
    }

    #[Route('/profil/edit', name: 'user_edit_profil', methods: ['GET', 'POST'])]
    public function editProfil(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($this->getUser());
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // condition to user who have select 2 or more lang has automaticaly the role traductor in dbb, but auto delete role if less than 2 lang
            if (count($user->getLanghasuser()) >= 2) {
                $user->setRoles(['ROLE_TRADUCTOR', 'ROLE_USER']);
            }
            else {
                $user->setRoles(['ROLE_USER']);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Profil updated');

            return $this->redirectToRoute('user_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit_profil.html.twig', [
            'form' => $form,
            // 'user' => $user,
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        // $userSession = $this->getUser()->getId();
        // if($user->getId() != $userSession->getId() )
        // {
        //         // user can't edit another user
        //         // $session->set("message", "Vous ne pouvez pas modifier cet utilisateur");
        //         return $this->redirectToRoute('user_show');
        // }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // condition to user who have select 2 or more lang has automaticaly the role traductor in dbb, but auto delete role if less than 2 lang
            if (count($user->getLanghasuser()) >= 2) {
                $user->setRoles(['ROLE_TRADUCTOR', 'ROLE_USER']);
            }
            else {
                $user->setRoles(['ROLE_USER']);
            }

            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
