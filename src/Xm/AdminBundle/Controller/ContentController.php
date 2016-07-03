<?php

namespace Xm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        return $this->render('XmAdminBundle::Content/index.html.twig');
    }
}
