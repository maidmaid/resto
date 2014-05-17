<?php

namespace Mnu\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $this->scan();
        
        $em = $this->getDoctrine()->getManager();
        /* @var $repository \Mnu\BotBundle\Entity\BotRestaurantRepository */
        $repository = $em->getRepository('MnuBotBundle:BotRestaurant');
        
        return $this->render('MnuBotBundle:Default:index.html.twig', array(
            'botRestaurants' => $repository->findAll()
        ));
    }
    
    private function scan()
    {
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
                return;
            }
        }
    }
    
    private function execute($url, $getFields, $postFields, $httpHeader)
    {
        if(file_exists('debug_original.html'))
        {
            $response = $this->urlExec($url, $getFields, $postFields, $httpHeader);
            file_put_contents('debug_original.html', $response['output']);
        }
        $html = file_get_contents('debug_original.html');
        
        $html = $this->repair($html);
        
        $botRestaurants = $this->parseBotRestaurants($html);
        
        foreach($botRestaurants as $botRestaurant)
        {
            $this->updateBotRestaurant($botRestaurant);
        }
    }
    
    private function urlExec($url, $getFields, $postFields, $httpHeader)
    {
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => $httpHeader,
            CURLOPT_URL => $url . '?' . http_build_query($getFields),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postFields)
        ));

        $output = curl_exec($ch); 

        $response = array(
            'output' => $output, 
            'info' => curl_getinfo($ch)
        );

        curl_close($ch);

        return $response;
    }
    
    private function updateBotRestaurant(\Mnu\BotBundle\Entity\BotRestaurant $botRestaurantRaw)
    {
        $em = $this->getDoctrine()->getManager();
        /* @var $repository \Mnu\BotBundle\Entity\BotRestaurantRepository */
        $repository = $em->getRepository('MnuBotBundle:BotRestaurant');
        
        $botRestaurants = $repository->findByNumber($botRestaurantRaw->getNumber());

        if(empty($botRestaurants))
        {
            $em->persist($botRestaurantRaw);
            $em->flush();
            return;
        }
        
        $botRestaurant = $botRestaurants[0];
        
        foreach($botRestaurantRaw->getLinks() as $link)
        {
            if(!$botRestaurant->linkExists($link->getUrl()))
            {
                $botRestaurant->addLink($link);
                $em->persist($botRestaurant);
            }
        }
        
        $em->flush();
    }
    
    private function parseBotRestaurants($html)
    {    
        $botRestaurants = array();
        
        // CssSelector
        $document = new \DOMDocument();
        $document->loadHTML($html);
        $xpath = new \DOMXPath($document);

        // Données
        foreach ($xpath->query(\Symfony\Component\CssSelector\CssSelector::toXPath('tr .A9')) as $restaurantNode)
        {   
            $botRestaurant = new \Mnu\BotBundle\Entity\BotRestaurant();
            
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
                $link = new \Mnu\BotBundle\Entity\BotRestaurantLink();
                $link->setUrl($url);
                $botRestaurant->addLink($link);
            }

            $botRestaurants[] = $botRestaurant;
        }
        
        return $botRestaurants;
    }
    
    private function repair($response)
    {
        $response = tidy_repair_string($response, array(
            'clean' => true,
            'wrap' => 1024,
            'indent' => true,
            'indent-spaces' => 4
        ));
        $response = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">', '', $response);
        $response = str_replace('id="central" ', '', $response);
        
        // Debug
        file_put_contents('debug.html', $response);
        
        return $response;
    }
}
