<?php

namespace Mnu\BotBundle\Bot;

use Mnu\BotBundle\Entity\BotRestaurant;
use Mnu\BotBundle\Entity\BotRestaurantLink;
use Symfony\Component\CssSelector\CssSelector;

class BotRestoCh extends BotAbstract implements BotInterface
{
    public function scan()
    {
        parent::scan();
        
        $cantons = array('vs', 'vd', 'ge');
        
        foreach ($cantons as $canton)
        {
            for ($page = 1; $page <= 1; $page++)
            {
                $url = 'http://www.resto.ch/home/xx.php';

                $getFields = array(
                    'lg' => 'fr',
                    'ct' => $canton,
                    'motcle' => '', 
                    'cu' => '' 
                 );

                $postFields = array(
                    'selpage' => $page
                );

                $httpHeader = array(
                    'Referer: http://www.resto.ch'
                );

                $this->execute($url, $getFields, $postFields, $httpHeader);
            }
        }
    }
    
    public function repair($response)
    {
        $response = parent::repair($response);
        
        $response = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">', '', $response);
        $response = str_replace('id="central" ', '', $response);
        
        return $response;
    }
    
    public function parseBotRestaurants($html)
    {
        parent::parseBotRestaurants($html);
        
        // Données
        foreach ($this->xpath->query(CssSelector::toXPath('tr .A9')) as $restaurantNode)
        {   
            $botRestaurant = new BotRestaurant();
            
            // Number
            $phoneStr = str_replace(' ', '', $restaurantNode->nodeValue);
            preg_match('/\d{10}/', $phoneStr, $phone);

            if(empty($phone))
            {
                continue;
            }

            // Number
            $number = $phone[0];
            $botRestaurant->setNumber($phone[0]);

            // Name
            $name = $restaurantNode->getElementsByTagName('b')->item(0)->nodeValue;
            $botRestaurant->setName($name);

            // Urls
            foreach($restaurantNode->getElementsByTagName('a') as $linkNode)
            {
                $url = $linkNode->getAttribute('href');
                $link = new BotRestaurantLink();
                $link->setUrl($url);
                $botRestaurant->addLink($link);
            }

            $botRestaurants[] = $botRestaurant;
        }
        
        return $botRestaurants;
    }
}
