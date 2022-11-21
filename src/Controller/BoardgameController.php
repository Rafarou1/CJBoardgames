<?php

namespace App\Controller;

use App\Entity\Boardgame;
use App\Form\BoardgameType;
use App\Repository\BoardgameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boardgame")
 */
class BoardgameController extends AbstractController
{
    /**
     * @Route("/", name="app_boardgame_index", methods={"GET"})
     */
    public function index(BoardgameRepository $boardgameRepository): Response
    {
        return $this->render('boardgame/index.html.twig', [
            'boardgames' => $boardgameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_boardgame_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BoardgameRepository $boardgameRepository): Response
    {
        $boardgame = new Boardgame();
        $form = $this->createForm(BoardgameType::class, $boardgame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boardgameRepository->add($boardgame, true);

            return $this->redirectToRoute('app_boardgame_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boardgame/new.html.twig', [
            'boardgame' => $boardgame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_boardgame_show", methods={"GET"})
     */
    public function show(Boardgame $boardgame): Response
    {
        return $this->render('boardgame/show.html.twig', [
            'boardgame' => $boardgame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_boardgame_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Boardgame $boardgame, BoardgameRepository $boardgameRepository): Response
    {
        $form = $this->createForm(BoardgameType::class, $boardgame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boardgameRepository->add($boardgame, true);

            return $this->redirectToRoute('app_boardgame_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boardgame/edit.html.twig', [
            'boardgame' => $boardgame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_boardgame_delete", methods={"POST"})
     */
    public function delete(Request $request, Boardgame $boardgame, BoardgameRepository $boardgameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boardgame->getId(), $request->request->get('_token'))) {
            $boardgameRepository->remove($boardgame, true);
        }

        return $this->redirectToRoute('app_boardgame_index', [], Response::HTTP_SEE_OTHER);
    }
}
