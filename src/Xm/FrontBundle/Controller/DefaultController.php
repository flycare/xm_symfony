<?php

namespace Xm\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
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
        $title = '';
        return $this->render('XmFrontBundle:Default:index.html.twig',array(
            'content'=>$content,
            'title'=>$title
        ));
    }

    /**
     * @Route("/page/{slug}", name="webpage")
     */
    public function pageAction($slug){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag($slug);
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigation = $repository->findOneByFlag($slug);
        return $this->render('XmFrontBundle:Default:index.html.twig',array(
            'content'=>$page->getContent(),
            'title'=>$navigation->getTitle().' - '
        ));
    }

    public function navigationAction(){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigations = $repository->findBy(array('level'=>1,'enable'=>1),array('weight'=>'ASC'));
        return $this->render('XmFrontBundle:Default:navigation.html.twig',array(
            'navigations'=>$navigations
        ));
    }

    /**
     * @Route("/activity/{id}", name="activity")
     */
    public function activityAction($id){

    }

    public function bottomAction(){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag('bottom');
        return $this->render('XmFrontBundle:Default:bottom.html.twig',array(
            'content'=>$page->getContent()
        ));
    }
}
