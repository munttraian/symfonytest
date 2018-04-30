<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {
    
    public function index() {
        
        //$volumesColl = $this->getDoctrine()->getRepository('App:Volumes')->findAll();
        $volumesColl = $this->getDoctrine()->getRepository('App:Volumes')->findAll();
        
        $volumes = array();
        
        foreach ($volumesColl as $volumeItem) {
            $volumes[$volumeItem->getId()] = array(
                'id' => $volumeItem->getId(),
                'name' => $volumeItem->getName(),
                'author' => $volumeItem->getAuthor()
            );
        }
        
        return $this->render('Default/index.html.twig', array('volumes' => $volumes));
        
    }
    
}
