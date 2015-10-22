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
        $adminView->showIPList($logFacade);
    }

    public function loggStuff(LogFacade $logFacade) {
        $logFacade->loggHeader("Test");
        $logFacade->loggThis("testar igen");
        $logFacade->loggThis("Test", null, true);
        $logFacade->loggThis("Från en annan ip include an object", new \Exception("foo exception"), false);
    }
}

//show log
//do not dump superglobals
//echoLog(false);

//show with superglobals
//echoLog();
