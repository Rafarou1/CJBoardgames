<?php

namespace App\Controller;

use App\Entity\Boardgame;
use App\Entity\Reserve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

//     /**
//  * Controleur Reserve
//  * @Route("/reserve")
//  */

class ReserveController extends AbstractController
{    
    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function index(): Response
    {

    return $this->render('index.html.twig',
        [ 'welcome' => "Accueil des réserves" ]
    );
    }


    /**
     * Lists all reserve entities.
     *
     * @Route("/reserve", name = "app_reserve", methods="GET")
     */
    public function listAction(ManagerRegistry $doctrine): Response
    {
    $entityManager= $doctrine->getManager();
    $reserves = $entityManager->getRepository(Reserve::class)->findAll();

    dump($reserves);

    return $this->render('reserve/index.html.twig',
        [ 'reserves' => $reserves ]
        );

    }

    /**
 * Show a reserve
 * 
 * @Route("/reserve/{id}", name="reserve_show", requirements={"id"="\d+"})
 *    note that the id must be an integer, above
 *    
 * @param Integer $id
 */
    public function showAction(ManagerRegistry $doctrine, Reserve $reserve): Response
{
    $entityManager= $doctrine->getManager();
    $boardgames = $entityManager->getRepository(Boardgame::class)->findBy(array('reserve' => $reserve->getId()));

    dump($boardgames);
   
    return $this->render('reserve/show.html.twig',
    [ 
        'boardgames' => $boardgames,
        'reserve' => $reserve
    ]
    );
}


}