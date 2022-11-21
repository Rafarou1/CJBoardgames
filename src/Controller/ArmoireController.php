<?php

namespace App\Controller;

use App\Entity\Armoire;
use App\Form\ArmoireType;
use App\Repository\ArmoireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/armoire")
 */
class ArmoireController extends AbstractController
{
    /**
     * @Route("/", name="app_armoire_index", methods={"GET"})
     */
    public function index(ArmoireRepository $armoireRepository): Response
    {
        return $this->render('armoire/index.html.twig', [
            'armoires' => $armoireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_armoire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArmoireRepository $armoireRepository): Response
    {
        $armoire = new Armoire();
        $form = $this->createForm(ArmoireType::class, $armoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $armoireRepository->add($armoire, true);

            return $this->redirectToRoute('app_armoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('armoire/new.html.twig', [
            'armoire' => $armoire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_armoire_show", methods={"GET"})
     */
    public function show(Armoire $armoire): Response
    {
        return $this->render('armoire/show.html.twig', [
            'armoire' => $armoire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_armoire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Armoire $armoire, ArmoireRepository $armoireRepository): Response
    {
        $form = $this->createForm(ArmoireType::class, $armoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $armoireRepository->add($armoire, true);

            return $this->redirectToRoute('app_armoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('armoire/edit.html.twig', [
            'armoire' => $armoire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_armoire_delete", methods={"POST"})
     */
    public function delete(Request $request, Armoire $armoire, ArmoireRepository $armoireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$armoire->getId(), $request->request->get('_token'))) {
            $armoireRepository->remove($armoire, true);
        }

        return $this->redirectToRoute('app_armoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
