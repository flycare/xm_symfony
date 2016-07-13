<?php

namespace Xm\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Xm\AdminBundle\Entity\Pages;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag('home');
        $content = $page->getContent();
        return $this->render('XmFrontBundle:Default:index.html.twig',array(
            'content'=>$content
        ));
    }

    /**
     * @Route("/page/{slug}", name="webpage")
     */
    public function pageAction($slug){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag($slug);
        $content = $page->getContent();
        $this->render('XmFrontBundle:Default:page.html.twig',array(
            'content'=>$content
        ));
    }

    public function navigationAction(){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigations = $repository->findAll(array(),array('weight'=>'ASC'));
        return $this->render('XmFrontBundle:Default:navigation.html.twig',array(
            'navigations'=>$navigations
        ));
    }
}
