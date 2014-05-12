<?php

namespace Mnu\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        for ($page = 1; $page <= 1; $page++)
        {
            $url = 'http://www.resto.ch/home/xx.php';

            $getFields = array(
                'lg' => 'fr',
                'ct' => 'vs',
                'motcle' => '', 
                'cu' => '' 
             );

            $postFields = array(
                'selpage' => $page
            );

            $httpHeader = array(
                'Referer: http://www.resto.ch'
            );

            // cURL
            $response = $this->urlExec($url, $getFields, $postFields, $httpHeader);
            //file_put_contents('debug_original.html', $response['output']);
            //$response['output'] = file_get_contents('debug_original.html');
            
            // Erreurs
            $response['output'] = tidy_repair_string($response['output'], array(
                'clean' => true,
                'wrap' => 1024,
                'indent' => true,
                'indent-spaces' => 4
            ));
            $response['output'] = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">', '', $response['output']);
            $response['output'] = str_replace('id="central" ', '', $response['output']);
            file_put_contents('debug.html', $response['output']);
            
            // CssSelector
            $document = new \DOMDocument();
            $document->loadHTML($response['output']);
            $xpath = new \DOMXPath($document);
            
            // Données
            foreach ($xpath->query(\Symfony\Component\CssSelector\CssSelector::toXPath('tr .A9')) as $restaurantNode)
            {
                // Number
                $phoneStr = str_replace(' ', '', $restaurantNode->nodeValue);
                preg_match('/\d{10}/', $phoneStr, $phone);
                
                if(empty($phone))
                {
                    continue;
                }
                
                $number = $phone[0];
                
                // Name
                $name = $restaurantNode->getElementsByTagName('b')->item(0)->nodeValue;
                
                // Urls
                $urls = array();
                foreach($restaurantNode->getElementsByTagName('a') as $linkNode)
                {
                    $urls[] = $linkNode->getAttribute('href');
                }

                // Persistance
                $em = $this->getDoctrine()->getManager();
                /* @var $repository \Mnu\BotBundle\Entity\BotRestaurantRepository */
                $repository = $em->getRepository('MnuBotBundle:BotRestaurant');
                $botRestaurants = $repository->findByNumber($number);
                
                if(empty($botRestaurants))
                {
                    $botRestaurant = new \Mnu\BotBundle\Entity\BotRestaurant();
                }
                else
                {
                    $botRestaurant = $botRestaurants[0];
                }
                
                $botRestaurant->setNumber($number);
                $botRestaurant->setName($name);
                
                foreach($urls as $url)
                {
                    if(!$botRestaurant->linkExists($url))
                    {
                        $link = new \Mnu\BotBundle\Entity\BotRestaurantLink();
                        $link->setUrl($url);
                        $botRestaurant->addLink($link);
                        $em->persist($botRestaurant);
                    }
                }
            }
            
            $em->flush();
        }

        return $this->render('MnuBotBundle:Default:index.html.twig', array(
            'botRestaurants' => $repository->findAll()
        ));
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
}
