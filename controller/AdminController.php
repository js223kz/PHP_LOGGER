<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:36
 */

namespace controller;


use model\LogFacade;
use view\AdminView;

class AdminController{

    public function __construct(LogFacade $logFacade, AdminView $adminView){
        //$this->loggStuff($logFacade);
        $adminView->getIPList($logFacade);
    }

    public function loggStuff(LogFacade $logFacade) {
        $logFacade->loggHeader("Ettan");
        $logFacade->loggHeader("Ettan");
        $logFacade->loggThis("Ettan igen");
        $logFacade->loggThis("Ett", null, true);
        $logFacade->loggThis("Från en Ettan include an object", new \Exception("foo exception"), false);
    }
}

//show log
//do not dump superglobals
//echoLog(false);

//show with superglobals
//echoLog();
