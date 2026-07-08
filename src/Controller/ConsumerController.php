<?php

namespace App\Controller;

use App\Entity\Consumer;
use App\Form\ConsumerType;
use App\Repository\ConsumerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/consumer')]
final class ConsumerController extends AbstractController
{
    #[Route(name: 'app_consumer_index', methods: ['GET'])]
    public function index(ConsumerRepository $consumerRepository): Response
    {
        return $this->render('consumer/index.html.twig', [
            'consumers' => $consumerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_consumer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consumer = new Consumer();
        $form = $this->createForm(ConsumerType::class, $consumer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consumer);
            $entityManager->flush();

            return $this->redirectToRoute('app_consumer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consumer/new.html.twig', [
            'consumer' => $consumer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consumer_show', methods: ['GET'])]
    public function show(Consumer $consumer, Security $security): Response
    {
        $user = $security->getUser();

        if (($user && $user->getConsumer() && $user->getConsumer()->getId() == $consumer->getId()) || $user->getRoles()[0] == 'ROLE_ADMIN') {
            return $this->render('consumer/show.html.twig', [
                'consumer' => $consumer,
            ]);
        }

        return $this->redirectToRoute('app_package_index');
    }

    #[Route('/{id}/edit', name: 'app_consumer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consumer $consumer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsumerType::class, $consumer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consumer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consumer/edit.html.twig', [
            'consumer' => $consumer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consumer_delete', methods: ['POST'])]
    public function delete(Request $request, Consumer $consumer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consumer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($consumer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consumer_index', [], Response::HTTP_SEE_OTHER);
    }
}
