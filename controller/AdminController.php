<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:36
 */

namespace controller;


use model\LogFacade;

class AdminController{

    public function __construct(LogFacade $logFacade){
        $this->loggStuff($logFacade);
        $logFacade->getLogAllItems();
        $logFacade->echoLog(false);

    }

    public function loggStuff(LogFacade $logFacade) {
    $logFacade->loggHeader("A header");
    //loggThis("write a message");
    //loggThis("include call trace", null, true);
    //loggThis("include an object", new \Exception("foo exception"), false);
    }
}

//show log
//do not dump superglobals
//echoLog(false);

//show with superglobals
//echoLog();
