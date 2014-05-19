<?php

namespace Mnu\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $botRestoCh = $this->get('bot.restoch');
        $botRestoCh->scan();
        
        $em = $this->getDoctrine()->getManager();
        /* @var $repository \Mnu\BotBundle\Entity\BotRestaurantRepository */
        $repository = $em->getRepository('MnuBotBundle:BotRestaurant');
        
        return $this->render('MnuBotBundle:Default:index.html.twig', array(
            'botRestaurants' => $repository->findAll()
        ));
    }
}