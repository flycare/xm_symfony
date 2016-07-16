<?php

namespace Xm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Xm\AdminBundle\Entity\Pages;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * Class ContentController
 * @package Xm\AdminBundle\Controller
 * @Route("/content")
 */
class ContentController extends Controller
{
    /**
     * @Route("/list",name="page_content_list")
     */
    public function listAction(){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Navigation');
        $navigations = $repository->findAll();
        return $this->render('XmAdminBundle:Content:list.html.twig',array(
            'navigations'=>$navigations
        ));
    }
    /**
     * @Route("/manage/{flag}", name="page_content_manage")
     */
    public function manageAction($flag){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $obj = $repository->findOneByFlag($flag);
        $page = new Pages();
        $builder = $this->createFormBuilder($page)
            ->setAction($this->generateUrl('ajax_save_content'))
            ->add('content', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
                'config' => array(
                    'allowedContent'=> true,
                    'toolbar'=>'full',
                    'value'=>$obj->getContent(),
                    'contentsCss'=>array(
                        '/bundles/xmfront/css/index.css',
                        '/bundles/xmfront/css/header.css'
                    )
                ),
                'plugins' => array(
                    'backgrounds' => array(
                        'path'     => '/bundles/xmadmin/ckeditor/plugins/backgrounds',
                        'filename' => 'plugin.js',
                    ),
                ),
                'label'=>' ',
                'data'=>$obj->getContent()
            ))
            ->getForm();

        return $this->render('XmAdminBundle:Content:index.html.twig',array(
            'form' => $builder->createView(),
            'obj'=>$obj
        ));
    }

    /**
     * @Route("/saveContent", name="ajax_save_content")
     */
    public function ajaxSaveContentAction(){
        $data = $this->get("request")->request->all();
        $content = $data['form']['content'];
        $flag = $data['flag'];
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $em = $this->getDoctrine()->getEntityManager();
        $page = $repository->findOneByFlag($flag);
        $page->setContent($content);
        $page->setLastModify(new \DateTime('now'));
        $em->persist($page);
        $em->flush();
        return $this->redirectToRoute('page_content_list');
    }

    public function lastModifyAction($flag){
        $repository = $this->getDoctrine()->getRepository('XmAdminBundle:Pages');
        $page = $repository->findOneByFlag($flag);
        return $this->render('XmAdminBundle:Content:last_modify.html.twig',array(
            'lastModify'=>$page->getLastModify()
        ));
    }
}
