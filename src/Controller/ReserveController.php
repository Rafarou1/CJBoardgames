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
        return new Response(
            '<html>
    <body> Bienvenue dans notre réserve !
        <ul>
            <li>Jetez un oeil aux jeux présents dans les réserves</li>
            <li>Demandez des précisions aux joueurs</li>
        </ul>
    </body>
</html>'

    );
    return $this->render('reserve/index.html.twig', [
        'controller_name' => 'ReserveController',
    ]);
    }

//         $htmlpage = '<!DOCTYPE html>
// <html>
//     <head>
//         <meta charset="UTF-8">
//         <title>Welcome!</title>
//     </head>
//     <body>
//         <h1>Welcome</h1>
            
//     <p>Bienvenue dans notre reserve</p>
//     </body>
// </html>';
        
        // return new Response(
        //     $htmlpage,
        //     Response::HTTP_OK,
        //     array('content-type' => 'text/html')
        //     );
    // }

    /**
     * Lists all reserve entities.
     *
     * @Route("/reserve", name = "app_reserve", methods="GET")
     */
    public function listAction(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Réserves</title>
    </head>
    <body>
        <h1>Réserves</h1>
        <p>Voici les reserves partagées sur notre site:</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $reserves = $entityManager->getRepository(Reserve::class)->findAll();
        foreach($reserves as $reserve) {
           $htmlpage .= '<li>
            <a href="/reserve/'.$reserve->getid().'">'.$reserve->getName().'</a></li>';
         }

        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }

    /**
 * Show a reserve
 * 
 * @Route("/reserve/{id}", name="reserve_show", requirements={"id"="\d+"})
 *    note that the id must be an integer, above
 * @Route("/index", name="reserve_index", methods="GET")
 *    
 * @param Integer $id
 */
    public function show(ManagerRegistry $doctrine, $id)
{
       
        $reserveRepo = $doctrine->getRepository(reserve::class);
        $reserve = $reserveRepo->find($id);

        if (!$reserve) {
          throw $this->createNotFoundException('The reserve does not exist');
     }

        $res = '<!DOCTYPE html>
        <html>
         <head>
             <meta charset="UTF-8">
             <title>Boardgames</title>
         </head>
         <body>
             <h1>Jeu de sociétés</h1>
             <p>Voici les jeux contenus dans cette réserve:</p>
             <ul>';


        $entityManager= $doctrine->getManager();
        $boardgames = $entityManager->getRepository(Boardgame::class)->findAll();
        foreach($boardgames as $boardgame) {
            $res .= '<li>
            <a href="/boardgame/'.$boardgame->getid().'">'.$boardgame->getName().'</a></li>';

      }


        $res .= '<p/><a href="' . $this->generateUrl('reserve_index') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
}


}