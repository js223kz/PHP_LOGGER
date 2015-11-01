<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:36
 */

namespace controller;

require_once('view/SessionListView.php');
require_once('view/IPListView.php');
require_once('view/SpecificSessionView.php');

use model\LogService;


class AdminController{

    private $sessionList;
    private $ipListView;

    public function __construct(LogService $logService){
        $this->sessionList = new \view\SessionListView($logService);
        $this->ipListView = new \view\IPListView($logService);
        $this->echoView($logService);

        //$this->loggStuff($logService);
    }

    //examples of how to log specific items
    public function loggStuff(LogService $logService) {
        $logService->loggHeader("Ny session");
        $logService->loggThis("Från ett annat ip-nummer");
        $logService->loggThis("Annat ip-nummer", null, true);
        $logService->loggThis("Från ett annat ip-nummer inkluderar ett objekt", new \Exception("foo exception"), false);
    }

    //render views depending on user input
    public function echoView($logService){
        if($this->ipListView->ipLinkIsClicked()){
            $this->sessionList->getSessionList($this->ipListView->getIP());
        }else if($this->sessionList->sessionLinkIsClicked()){
            $specificSessionView = new \view\SpecificSessionView($logService);
            $specificSessionView->getSpecificSessionList($this->sessionList->getSession());
        }else{
            $this->ipListView->getIPList();
        }
    }
}
