<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Players;
use GuzzleHttp\Client;

class DefaultController extends Controller
{
    /**
     * @Route("/rest/getPlayers/")
     * @Route("/rest/getPlayers/{id}")
    */

    public function getPlayers($id = null)
    {         
        $serializer = $this->get('serializer');      

        // Fetching data using Doctrine.
    
        $em = $this->getDoctrine()->getManager();
        if ($id == null) {
            $players = $em->getRepository('AppBundle:Players') ->findAll();
        } else {            
            $players[0] = $em->getRepository('AppBundle:Players') ->findOneById($id);
        }

        // End data.
        
        $data = $serializer->normalize($players);    // Without normalize, it returns private data and it won't work.
        return new JsonResponse($data);
    }

    public function getRest($id = null, $rest_url = null) {        
        $client = new Client();
        $res = $client->request('GET', $rest_url."/".$id);
        if($res->getStatusCode() === 200) {
            $data = json_decode($res->getBody(), true);
        }            
        return new JsonResponse($data);
    } 

    /**
     * @Route("/", name="homepage")
     * @Route("/player/{id}", name="player")
    */

    public function Render_Player_s(Request $request, $id = null)
    {
        $fullbaseUrl = $request->getSchemeAndHttpHost().$this->container->get('router')->getContext()->getBaseUrl();
        
        /* Note: Since the PHP built-in server is single threaded, requesting another url on your server will halt first request and it gets timed out, so when using this app in PHP built-in server (http://127.0.0.1:8000 for example) the next function won't work.
        So IN THIS CASE, I call to the function (getPlayers) instead of the HTTP request. In the other cases, it works properly. */
        
        //$request_players = $this->getRest($id, $base_url.'/rest/getPlayers');
        
        $request_players = $this->getPlayers($id);
    
        $players = json_decode($request_players->getContent(), true); 
        return $this->render('react_example.html.twig', [
                 'props' => [
                    'players' => $players,
                    'baseUrl' => $this->generateUrl('homepage'),
                    'location' => $request ->getRequestUri()
                    ] 
        ]);
    }
    
    /**
     * @Route("/insertPlayer")
     */
    
    public function insertPlayer()
    {   
        $data  = json_decode(file_get_contents('php://input'), true); 
        $data = $data['player'];        
        $players = new Players();
        $players->setNewPlayer($data['name'],$data['email']);        
        $em = $this->getDoctrine()->getManager();
        $em->persist($players);
        $em->flush();
        return new Response();
    }
}