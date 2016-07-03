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
     * @Route("/manage", name="page_content_manage")
     */
    public function manageAction(){
        $page = new Pages();
        $builder = $this->createFormBuilder($page)
            ->add('content', CKEditorType::class, array(
                'config' => array(
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => array(
                        'instance' => 'default',
                        'homeFolder' => ''
                    )
                ),
                'label'=>' '
            ))
            ->getForm();

        return $this->render('XmAdminBundle::Content/index.html.twig',array(
            'form' => $builder->createView(),
        ));
    }
}
