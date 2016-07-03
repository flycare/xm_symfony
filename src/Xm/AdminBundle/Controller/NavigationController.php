<?php

namespace Xm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Xm\AdminBundle\Entity\Navigation;
use Symfony\Component\HttpFoundation\Response;
use Overtrue\Pinyin\Pinyin;

/**
 * Class NavigationController
 * @package Xm\AdminBundle\Controller
 * @Route("/navigation")
 */
class NavigationController extends BaseController
{
    /**
     * @Route("/manage", name="navigation_manage")
     */
    public function manageAction(){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigations = $repository->findAll();
        return $this->render('XmAdminBundle::Navigation/index.html.twig',array(
            'navigations'=>$navigations
        ));
    }

    /**
     * @Route("/ajax/create", name="ajax_create_menu")
     */
    public function ajaxCreateMenu(){
        $data = $this->get("request")->request->all();
        $em = $this->getDoctrine()->getEntityManager();
        $navigation = new Navigation();
        $navigation->setTitle($data['title']);
        $navigation->setWeight($data['weight']);
        $pinyin = new Pinyin();
        $flag = $pinyin->permalink($data['title']);
        $navigation->setFlag($flag);
        $em->persist($navigation);
        $em->flush();
        $response = new Response(json_encode(array('result' => true)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ajax/save", name="ajax_save_menu")
     */
    public function ajaxSaveMenu(){
        $data = $this->get("request")->request->all();
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigation = $repository->find($data['id']);
        $navigation->setTitle($data['title']);
        $navigation->setWeight($data['weight']);
        $pinyin = new Pinyin();
        $flag = $pinyin->permalink($data['title']);
        $navigation->setFlag($flag);
        $em->persist($navigation);
        $em->flush();
        $response = new Response(json_encode(array('result' => true)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ajax/delete", name="ajax_delete_menu")
     */
    public function ajaxDeleteMenu(){
        $data = $this->get("request")->request->all();
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigation = $repository->find($data['id']);
        $em->remove($navigation);
        $em->flush();
        $response = new Response(json_encode(array('result' => true)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
