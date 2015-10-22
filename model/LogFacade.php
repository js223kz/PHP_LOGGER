<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-22
 * Time: 13:35
 */

namespace model;
require_once("model/LogDAL.php");
require_once("model/LogItem.php");
require_once("view/LogView.php");

class LogFacade
{

    private $saveNewLogItem;

    public function __construct(){
        $this->saveNewLogItem = new LogDAL();
    }

    function loggThis($logMessageString, $logThisObject = null, $includeTrace = false) {
        $this->saveNewLogItem->AddLogItem(new \model\LogItem($logMessageString, $includeTrace, $logThisObject));
    }

    function loggHeader($logMessageString) {
       $this->saveNewLogItem->AddLogItem(new \model\LogItem("<h2>$logMessageString</h2>", null, false));
    }

    /**
     * echo the log to the output buffer
     *
     * @param boolean $doDumpSuperGlobals dump $_GET, $_POST etc
     */
    function echoLog($doDumpSuperGlobals = true) {
        global $logCollection;
        $logView = new \model\LogView($logCollection);
        echo $logView->getDebugData($doDumpSuperGlobals);
    }

    function getLogAllItems()
    {
        $getLogItems = new \model\LogDAL();
        $getLogItems->getAllLogItems();
        /*foreach ($getLogItems->getAllLogItems() as $item) {
            var_dump($item["id"]);
        }*/
    }
}