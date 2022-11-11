<?php

namespace App\Controller;

use App\Entity\Reserve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

    /**
 * Controleur Reserve
 * @Route("/reserve")
 */

class ReserveController extends AbstractController
{    
    /**
     * @Route("/", name = "home", methods="GET")
     */
    public function indexAction()
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome!</title>
    </head>
    <body>
        <h1>Welcome</h1>
            
    <p>Bienvenue dans notre reserve</p>
    </body>
</html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }

    public function listAction(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>reserves!</title>
    </head>
    <body>
        <h1>reserves</h1>
        <p>Here are all your reserves:</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $reserves = $entityManager->getRepository(Reserve::class)->findAll();
        foreach($reserves as $reserve) {
           $htmlpage .= '<li>
            <a href="/reserve/'.$reserve->getid().'">'.$reserve->getTitle().'</a></li>';
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
     * Finds and displays a reserve entity.
     *
     * @Route("/{id}", name="reserve_show", requirements={ "id": "\d+"}, methods="GET")
     */
    public function showAction(Reserve $reserve): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>todo n° '.$reserve->getId().' details</title>
    </head>
    <body>
        <h2>Reserve Details :</h2>
        <ul>
        <dl>';
        
        $htmlpage .= '<dt>Reserve</dt><dd>' . $reserve->getName() . '</dd>';
        $htmlpage .= '<dt>Date de création</dt> <dd> ' . $reserve->getCreated()->format('Y-m-d') . '</dd>';
        $htmlpage .= '<dt>Date de modification</dt> <dd> '. $reserve->getUpdated()->format('Y-m-d') . '</dd>';
        $htmlpage .= '</dl>';
        $htmlpage .= '</ul></body></html>';
                
        return new Response(
                $htmlpage,
                Response::HTTP_OK,
                array('content-type' => 'text/html')
                );
    }
}
