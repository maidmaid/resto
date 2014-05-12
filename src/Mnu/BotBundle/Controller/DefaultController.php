<?php

namespace Mnu\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        for ($page = 1; $page <= 2; $page++)
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
            file_put_contents('debug_original.html', $response['output']);
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
                // Phone
                $phoneStr = str_replace(' ', '', $restaurantNode->nodeValue);
                preg_match('/\d{10}/', $phoneStr, $phone);
                $id = $phone[0];
                
                $restaurant = array();
                $restaurant['id'] = $id;
                $restaurant['name'] = $name = $restaurantNode->getElementsByTagName('b')->item(0)->nodeValue;
                $restaurant['url'] = $restaurantNode->getElementsByTagName('a')->item(0)->getAttribute('href');
                $restaurant['url2'] = $restaurantNode->getElementsByTagName('a')->length == 2 ?
                        $restaurantNode->getElementsByTagName('a')->item(1)->getAttribute('href') :
                        '';
                $restaurants[] = $restaurant;
            }
        }
        
        return $this->render('MnuBotBundle:Default:index.html.twig', array(
            'restaurants' => $restaurants
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
