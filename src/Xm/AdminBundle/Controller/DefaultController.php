<?php

namespace Xm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Libs\Captcha\ValidateCode;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction()
    {
        return $this->render('XmAdminBundle:Default:index.html.twig');
    }

    public function layoutAction(){
        $user = $this->getUser();
        $userName = '';
        if($user){
            $userName = $user->getUsernameCanonical();
        }
        return $this->render('XmAdminBundle:Default:username.html.twig',
            array(
                'username'=>$userName
            )
        );
    }
    /**
     * @Route("/login", name="admin_login")
     * @Template("XmAdminBundle:Default:login.html.twig")
     */
    public function loginAction(){

        $return = ['box'=>'login'];
        $request = $this->getRequest();
        $return['oauth_id'] = $request->get('oauth_id') ?: $this->get('session')->get('oauth_id');
        $admin_roles = ['ROLE_ADMIN'];
        if($request->getMethod() == 'POST'){
            $username = $request->get('username');
            $password = $request->get('password');
            if(!$username || !$password){
                $this->setFlash('error','请输入用户名和密码');
                return $return;
            }

            $um = $this->get('fos_user.user_manager');
            $user = $um->findUserBy(array("username"=>$username));
            if(!$user || !$user->isEnabled()){
                $this->setFlash('error','用户不存在');
                return $return;
            }

            $Encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $encrypted_pwd = $Encoder->encodePassword($password, $user->getSalt());

            if($encrypted_pwd != $user->getPassword()){
                $this->setFlash('error','密码错误');
                return $return;
            }
            $this->login($user);
            $response = $this->redirect($this->get('router')->generate('dashboard'));
            $this->rememberMe($request, $response);
            return $response;
        }

        //check if already login
        if($this->get('security.authorization_checker')->isGranted($admin_roles)){
            return $this->redirect($this->get('router')->generate('dashboard'));
        }elseif($this->get('security.authorization_checker')->isGranted(['ROLE_CUSTOMER'])){
            return $this->redirect($this->get('router')->generate('dashboard'));
        }else{
            return $return;
        }
    }

    /**
     * @Route("/captcha", name="captcha")
     */
    public function captchaAction(){
        $_vc = new ValidateCode();  //实例化一个对象
        $_vc->doimg();
        $session = $this->getRequest()->getSession();
        $session->set('captcha', $_vc->getCode() );//验证码保存到SESSION中
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logoutAction()
    {
        $this->get('request')->getSession()->invalidate();
        $this->get('security.token_storage')->setToken(null);


        $response = $this->redirect($this->get('router')->generate('admin_login'));
        $response->headers->setCookie(new \Symfony\Component\HttpFoundation\Cookie('REMEMBERME', '', 1));
        $response->headers->setCookie(new \Symfony\Component\HttpFoundation\Cookie('PHPSESSID', '', 1));

        return $response;
    }
}
