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

    public function __construct(LogService $logFacade, IPListView $ipListView){

        //$this->loggStuff($logFacade);
        if($ipListView->ipLinkIsClicked()){
            $selectedIP = $ipListView->getProductID();
            new \view\SessionListView($selectedIP);
        }else{
            $ipListView->getIPList($logFacade);
        }

    }

    public function loggStuff(LogService $logFacade) {
        //$logFacade->loggHeader("Hallojsa");
        //$logFacade->loggThis("Ettan igen");
        //$logFacade->loggThis("Ett", null, true);
        //$logFacade->loggThis("Från en Ettan include an object", new \Exception("foo exception"), false);
    }
}
