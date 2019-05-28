<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use App\Form\ConfigurationType;
use App\Repository\ConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuration")
 */
class AdminConfigurationController extends AbstractController
{
    /**
     * @Route("/", name="configuration_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(ConfigurationRepository $configurationRepository): Response
    {
        return $this->render('configuration/index.html.twig', [
            'configurations' => $configurationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="configuration_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $configuration = new Configuration();
        $form = $this->createForm(ConfigurationType::class, $configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($configuration);
            $entityManager->flush();

            return $this->redirectToRoute('configuration_index');
        }

        return $this->render('configuration/new.html.twig', [
            'configuration' => $configuration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="configuration_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Configuration $configuration): Response
    {
        return $this->render('configuration/show.html.twig', [
            'configuration' => $configuration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="configuration_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Configuration $configuration): Response
    {
        $form = $this->createForm(ConfigurationType::class, $configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('configuration_index', [
                'id' => $configuration->getId(),
            ]);
        }

        return $this->render('configuration/edit.html.twig', [
            'configuration' => $configuration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="configuration_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Configuration $configuration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configuration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($configuration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('configuration_index');
    }
}
