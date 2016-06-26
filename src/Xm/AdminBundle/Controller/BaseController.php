<?php

namespace Xm\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Xm\AdminBundle\Entity\User;

class BaseController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    public $user = null;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getOM(){
        return $this->get('doctrine')->getManager();
    }

    /**
     * @return \Xm\AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->get('xm')->getUser();
    }

    public function error($message = ''){
        $this->get('request')->setRequestFormat('html');

        $template = 'AppBundle:Default:error.html.twig';

        return $this->container->get('templating')->renderResponse($template, array('message'=>$message));
    }

    public function json_response($data = []){
        return (new \Symfony\Component\HttpFoundation\JsonResponse([
            'code' => 0,
            'data' => $data
        ]))->setStatusCode(200);
    }

    public function json_error($msg = ''){
        return (new \Symfony\Component\HttpFoundation\JsonResponse([
            'code' => 1,
            'msg' => $msg ?: 'Unknown Error'
        ]))->setStatusCode(400);
    }

//    /**
//     * @return \Xm\AdminBundle\Twig\Extension
//     */
//    public function getTwig(){
//        return $this->get('levco.twig.extension');
//    }

    /**
     * 登录
     */
    public function login(User $user){
        $this->container->get('fos_user.security.login_manager')->loginUser('main', $user);
        $user->setLastLogin(new \DateTime());
        $this->getOM()->persist($user);
        $this->getOM()->flush();
        return true;
    }

    /**
     * 记住登录状态
     */
    public function rememberMe($request, $response){
        $firewall_name = 'main';
        $securityKey = $this->container->getParameter('secret');
        $rememberMeService = new \Symfony\Component\Security\Http\RememberMe\TokenBasedRememberMeServices(
            array($this->container->get('fos_user.user_manager')),
            $securityKey,
            $firewall_name,
            array(
                'path' => '/',
                'name' => 'REMEMBERME',
                'domain' => null,
                'secure' => false,
                'httponly' => true,
                'lifetime' => $this->container->getParameter('remember_me_expire'),
                'always_remember_me' => true,
                'remember_me_parameter' => '_remember_me'
            ));

        $rememberMeService->loginSuccess($request, $response, $this->container->get('security.token_storage')->getToken());
        return true;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * @param string $action
     * @param string $value
     */
    public function setFlash($action, $value)
    {
        return $this->get('session')->getFlashBag()->set($action, $value);
    }
}
