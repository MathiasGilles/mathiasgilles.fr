<?php

namespace App\Controller;

use App\Entity\BusMagique;
use App\Entity\Game;
use App\Form\AddGorgeType;
use App\Form\BusMagiqueType;
use App\Form\GameType;
use App\Repository\BusMagiqueRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusController extends AbstractController
{
    /**
     * @Route("/bus", name="bus")
     * @param Request $request
     * @param BusMagiqueRepository $repo
     * @return Response
     */
    public function index(Request $request, BusMagiqueRepository $repo)
    {
        $busMagique = new BusMagique();

        $allPlayer = $repo->findAll();

        $form = $this->createForm(BusMagiqueType::class, $busMagique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $busMagique->setKm(0)
                ->setGorge(0)
                ->setGorgeeTotal(0)
                ->setKmTotal(0);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($busMagique);
            $manager->flush();
            $this->addFlash('success', "Joueur crée");
            return $this->redirectToRoute('bus');
        }

        return $this->render('bus/index.html.twig', [
            "BusForm" => $form->createView(),
            "players" => $allPlayer
        ]);
    }

    /**
     * @Route("/bus/create/game",name="bus_create_game")
     * @param Request $request
     * @param GameRepository $repo
     * @param BusMagiqueRepository $repository
     * @return RedirectResponse|Response
     */
    public function createGame(Request $request, GameRepository $repo, BusMagiqueRepository $repository)
    {
        $game = new Game();

        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();

            $game->setStatus(true);

            $oldGame = $repo->findAll();
            foreach ($oldGame as $item) {
                $item->setStatus(false);
                $manager->persist($item);
            }

            $playersInForm = $form['players']->getData();

            foreach ($playersInForm as $item) {
                $check = $repository->findOneBy(['player' => $item->getPlayer()]);

                if ($check === null) {
                    $this->addFlash('danger', "Remise à zéro d'un compteur à échoué pour un joueur");
                    return $this->redirectToRoute('bus_create_game');
                } else {
                    $check->setGorge(0)
                        ->setKm(0);
                    $manager->persist($check);
                }
            }

            $manager->persist($game);
            $manager->flush();

            $this->addFlash('success', "Partie lancée !");
            return $this->redirectToRoute("game_detail", array('id' => $game->getId()));
        }
        return $this->render('bus/new_game.html.twig', [
            'GameForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bus/game/{id}",name="game_detail")
     * @param Game $game
     * @param Request $request
     * @param BusMagiqueRepository $repo
     * @return Response
     */
    public function game(Game $game, Request $request, BusMagiqueRepository $repo)
    {
        $player = new BusMagique();

        $form = $this->createForm(AddGorgeType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $existPlayer = $repo->findOneBy(['player' => $form['player']->getData()]);
            if ($existPlayer === null) {
                $this->addFlash('danger', "Ce joueur n'existe pas");
                return $this->redirectToRoute('game_detail', ['id' => $game->getId()]);
            } else {
                $existPlayer->setGorge($player->getGorge())
                    ->setKm($player->getGorge() * 17);
                $this->addFlash('success', "Gorgée ajoutée, que ca carbure en sah");
                return $this->redirectToRoute('game_detail', ['id' => $game->getId()]);
            }
        }

        return $this->render('bus/game.html.twig', [
            'game' => $game,
            'addGorgeForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("game/get/last",name="game_get_last")
     * @param GameRepository $repo
     * @return RedirectResponse
     */
    public function getGameNotFinished(GameRepository $repo)
    {
        $game = $repo->findOneBy(['status'=>true]);
        if ($game === null){
            $this->addFlash('danger',"Il n'y a pas de partie en cours");
            return $this->redirectToRoute('bus');
        }
        return $this->redirectToRoute('game_detail',['id'=>$game->getId()]);

    }
}
