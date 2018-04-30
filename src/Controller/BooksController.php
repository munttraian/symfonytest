<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;


class BooksController extends Controller {
    
    /**
     * Get all volumes filter by term
     * @return JsonResponse
     */
    public function getVolumes() {
        
        $request = HttpRequest::createFromGlobals();
        $q = $request->query->get('term'); 
        
        //empty query string not allowed
        if (!trim($q)) {
            return new Response('Search term can not be empty', 400);
        }
        
        //for test purpose
        $q = ($q=="###")?'':$q;
        
        //get volumes
        $volumesColl = $this->getDoctrine()->getRepository('App:Volumes')->findAllByNameOrAuthor($q);
        
        //return if not volume found
        if (count($volumesColl) == 0) {
            return new Response('Not volume found', 404);
        }
        
        //construct volume array
        $volumes = array();
        
        foreach ($volumesColl as $volumeItem) {
            $volumes[] = array(
                'id' => $volumeItem->getId(),
                'name' => $volumeItem->getName(),
                'author' => $volumeItem->getAuthor(),
                'description' => $volumeItem->getDescription(),
                'image' => $volumeItem->getImage()
            );
        }
        
        return new JsonResponse($volumes);
        
    }
    
    /**
     * Get book volume by id
     * @param type $id
     * @return JsonResponse
     */
    public function getVolume($id) {
        
        $volume = $this->getDoctrine()->getRepository('App:Volumes')->find($id);
        
        $volumeArray = array(
            'id' => $volume->getId(),
            'name' => $volume->getName(),
            'author' => $volume->getAuthor()
        );
        
        return new JsonResponse($volumeArray);
    }
    
}