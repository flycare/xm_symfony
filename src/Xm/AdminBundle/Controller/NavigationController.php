<?php

namespace Xm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Xm\AdminBundle\Entity\Navigation;
use Symfony\Component\HttpFoundation\Response;
use Overtrue\Pinyin\Pinyin;
use Xm\AdminBundle\Entity\Pages;

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
        $navigations = $repository->findBy(array('level'=>1),array("weight"=>"ASC"));
        $subpages = $repository->findBy(array('level'=>2),array("weight"=>"ASC"));
        return $this->render('XmAdminBundle::Navigation/index.html.twig',array(
            'navigations'=>$navigations,
            'subpages'=>$subpages
        ));
    }
    /**
     * @Route("/ajax/enable", name="ajax_enable_menu")
     */
    public function ajaxSwitchEnable(){
        $data = $this->get("request")->request->all();
        $id = $data['id'];
        $enable = $data['enable'] == 1?0:1;
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigation = $repository->find($id);
        $navigation->setEnable($enable);
        $em->persist($navigation);
        $em->flush();
        $response = new Response(json_encode(array('result' => true)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/ajax/create", name="ajax_create_menu")
     */
    public function ajaxCreateMenu(){
        $data = $this->get("request")->request->all();
        $em = $this->getDoctrine()->getManager();
        $navigation = new Navigation();
        $navigation->setTitle($data['title']);
        $navigation->setWeight($data['weight']);
        $navigation->setLevel($data['level']);
        $pinyin = new Pinyin();
        $flag = $pinyin->permalink($data['title']);
        $navigation->setFlag($flag);
        $em->persist($navigation);
        $page = new Pages();
        $page->setFlag($flag);
        $now = new \DateTime('now');
        $page->setLastModify($now);
        $em->persist($page);
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
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigation = $repository->find($data['id']);
        $oldFlag = $navigation->getFlag();
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag($oldFlag);
        $navigation->setTitle($data['title']);
        $navigation->setWeight($data['weight']);
        $pinyin = new Pinyin();
        $flag = $pinyin->permalink($data['title']);
        $navigation->setFlag($flag);
        $page->setFlag($flag);
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
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigation = $repository->find($data['id']);
        $flag = $navigation->getFlag();
        $em->remove($navigation);
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag($flag);
        $em->remove($page);
        $em->flush();
        $response = new Response(json_encode(array('result' => true)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
