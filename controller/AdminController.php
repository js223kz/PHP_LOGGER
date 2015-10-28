<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:36
 */

namespace controller;

require_once('view/SessionListView.php');
use model\LogService;
use view\IPListView;
use view\SessionListView;

class AdminController{

    public function __construct(LogService $logService, IPListView $ipListView){

        //$this->loggStuff($logService);
        if($ipListView->ipLinkIsClicked()){
            $sessionList = new \view\SessionListView();
            $sessionList->getSessionList($ipListView->getProductID(), $logService);
        }else{
            $ipListView->getIPList($logService);
        }

    }

    public function loggStuff(LogService $logService) {
        //$logService->loggHeader("Hallojsa");
        //$logService->loggThis("Ettan igen");
        //$logService->loggThis("Ett", null, true);
        //$logService->loggThis("Från en Ettan include an object", new \Exception("foo exception"), false);
    }
}
