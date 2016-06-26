<?php
namespace Xm\AdminBundle\Util;

use Xm\AdminBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Xm {
    private static $mem;

    private $container;

    private $user = null;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->container->get('request');
        //return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEM(){
        return $this->container->get('doctrine')->getManager();
    }

    /**
     * get current user
     *
     * @return User
     */
    public function getUser(){
        if($this->user){
            return $this->user;
        }else{
            $token = $this->container->get('security.token_storage')->getToken();
            if($token === null)
                return null;
            $user = $token->getUser() ?: null;
            $this->user = is_object($user) ? $user : null;
            return $this->user;
        }
    }

    //static data
    public function mem($k, $v = null){
        if(is_null($v)){
            if(isset(self::$mem[$k]))
                return self::$mem[$k];

            return null;
        }
        self::$mem[$k] = $v;
        return $v;
    }

//    /**
//     * @param $type
//     * @param $object
//     * @return \Symfony\Component\EventDispatcher\Event
//     */
//    public function dispatch($type, $object){
//        return $this->container->get('event_dispatcher')->dispatch(
//            \Levco\Bundle\AdminBundle\LevcoEvents::LEVCO_EVENT,
//            (new \Levco\Bundle\AdminBundle\Event\Event())
//                ->setType($type)
//                ->setObject($object)
//        );
//    }

    /**
     * @param $queue
     * @param $data
     * @return int
     */
    public function enqueue($queue, $data){
        try{
            //put: data, priority(1024), delay(0), ttr(60)，这里ttr改为半个小时
            return $this->container->get("leezy.pheanstalk")->useTube($queue)->put($data, 1024, 0, 1800);
        }catch (\Exception $e){
            return $this->log('enqueue error: '.$e->getMessage());
        }
    }

    /**
     * log event
     * @param $type
     * @param $data
     * @return int
     */
    public function log_event($type, $data){
        return $this->enqueue('events', serialize([$type, $data]));
    }

    //log for debug
    public function log($info, $type = 'app'){
        $kernel = $this->container->get('kernel');
        $sEnvironment = $kernel->getEnvironment();
        $sLogName = $kernel->getRootDir()."/logs/".$type.".".$sEnvironment.".log";
        $log = new \Monolog\Logger($type);
        $log->pushHandler(new \Monolog\Handler\StreamHandler($sLogName));

        if(PHP_SAPI == 'cli'){
            $ip = 'cli';
        }else{
            $ip = $this->getRequest()->getClientIP();
        }
        $log->addInfo($ip.' '.$info);
        return true;
    }


    public function getTwig(){
        return $this->container->get('levco.twig.extension');
    }

} 

