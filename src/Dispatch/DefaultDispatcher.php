<?php

namespace src\Dispatch;

use src\Interfaces\DispatcherInterface;
use src\Model\Exceptions\NotFoundException;
use src\Routes\AbstractRoute;

class DefaultDispatcher implements DispatcherInterface
{

    private ?AbstractRoute $matched;

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): DefaultDispatcher
    {
        if (null === self::$instance){
            self::$instance = new DefaultDispatcher();
        }
        return self::$instance;
    }

    public function dispatch()
    {
        $request = $_SERVER["REQUEST_URI"];

        if (($pos = strpos($request, "?")) !== false){
            $request = substr($request, 0, $pos);
        }
        $this->matched = null;

        $this->findMatchingRoute($request);

        if (null === $this->matched){
            throw new NotFoundException();
        }

        $this->findControllerAndExecuteAction();

        if (null === $this->matched){
            throw new NotFoundException();
        }
    }

    /**
     * Loads the controller class
     * and executes the action
     * described by the request.
     * @throws NotFoundException
     */
    private function findControllerAndExecuteAction(){
        $controller = "\\src\\Controller\\" . ucfirst($this->matched->getParam("controller"));
        $action = $this->matched->getParam("action");


        $func = function ($className) {
            throw new \Exception();
        };
        spl_autoload_register($func);

        $ctl = null;

        try {
            $ctl = new $controller;
        } catch (\Exception $e) {
            throw new NotFoundException();
        }

        spl_autoload_unregister($func);

        if (!is_callable(array($ctl, $action))) {
            throw new NotFoundException();
        }
        $ctl->$action();
    }

    private function findMatchingRoute($request):void{
        foreach(AbstractRoute::get() as $route){
            if(!$route->match($request)){
                continue;
            }
            $this->matched = $route;
            break;
        }
    }
}