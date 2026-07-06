<?php

namespace App\Controller;

use App\Entity\BusinessType;
use App\Form\BusinessCategoryForm;
use App\Repository\BusinessTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/business_type')]
final class BusinessTypeController extends AbstractController
{
    #[Route(name: 'app_business_type_index', methods: ['GET'])]
    public function index(BusinessTypeRepository $businessTypeRepository): Response
    {
        return $this->render('business_type/index.html.twig', [
            'business_types' => $businessTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_business_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $businessType = new BusinessType();
        $form = $this->createForm(BusinessCategoryForm::class, $businessType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($businessType);
            $entityManager->flush();

            return $this->redirectToRoute('app_business_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('business_type/new.html.twig', [
            'business_type' => $businessType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_business_type_show', methods: ['GET'])]
    public function show(BusinessType $businessType): Response
    {
        return $this->render('business_type/show.html.twig', [
            'business_type' => $businessType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_business_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BusinessType $businessType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BusinessCategoryForm::class, $businessType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_business_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('business_type/edit.html.twig', [
            'business_type' => $businessType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_business_type_delete', methods: ['POST'])]
    public function delete(Request $request, BusinessType $businessType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$businessType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($businessType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_business_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
