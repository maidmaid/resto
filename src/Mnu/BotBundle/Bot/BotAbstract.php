<?php

namespace Mnu\BotBundle\Bot;

use DOMDocument;
use DOMXPath;
use Mnu\BotBundle\Entity\BotRestaurant;
use Mnu\BotBundle\Entity\BotRestaurantRepository;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpKernel\Kernel;

abstract class BotAbstract implements BotInterface
{
    protected $container;
    protected $botRestaurants = array();
    protected $xpath;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function scan()
    {
        
    }
    
    protected function execute($url, $getFields, $postFields, $httpHeader)
    {
        // Télécharge la liste de restaurants
        $nameRaw = $this->nameFileCache($url, $getFields, $getFields, '_raw');
        if(!file_exists($nameRaw))
        {
            $response = $this->urlExec($url, $getFields, $postFields, $httpHeader);
            file_put_contents($nameRaw, $response['output']);
        }
        $html = file_get_contents($nameRaw);
        
        // Répare le fichier
        $nameRepair = $this->nameFileCache($url, $getFields, $getFields, '_repair');
        $html = $this->repair($html);
        file_put_contents($nameRepair, $html);
        
        // Parse les restaurants du fichier
        $botRestaurants = $this->parseBotRestaurants($html);
        
        // Persiste les données
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
    
    private function updateBotRestaurant(BotRestaurant $botRestaurantRaw)
    {
        /* @var $repository BotRestaurantRepository */
        $em = $this->container->get('doctrine')->getManager();
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
    
    public function parseBotRestaurants($html)
    {    
        $this->prepareParsing($html);
    }
    
    public function repair($response)
    {
        $response = tidy_repair_string($response, array(
            'clean' => true,
            'wrap' => 1024,
            'indent' => true,
            'indent-spaces' => 4
        ));
        
        return $response;
    }

    protected function prepareParsing($html)
    {        
        $document = new DOMDocument();
        $document->loadHTML($html);
        $this->xpath = new DOMXPath($document);
    }
    
    private function nameFileCache($url, $getFields, $getFields, $suffixe)
    {
        /* @var $kernel Kernel */
        $kernel = $this->container->get('kernel');
        $path = $kernel->locateResource('@MnuBotBundle');
        $path .= 'cache/';
        
        if (!file_exists($path))
        {
            mkdir($path);
        }

        $name = $url . '?' . http_build_query($getFields) . http_build_query($getFields);
        $name = str_replace(':', '', $name);
        $name = str_replace('.', '', $name);
        $name = str_replace('/', '', $name);
        $name = str_replace('?', '', $name);
        $name = str_replace('&', '', $name);
        $name = str_replace('=', '', $name);
        $name .= $suffixe;
        
        return $path . $name;
    }
}