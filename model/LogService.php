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
require_once("view/LoggingView.php");

class LogService
{

    private $saveNewLogItem;

    public function __construct(){
        $this->saveNewLogItem = new LogDAL();
    }

    function loggThis($logMessageString, $logThisObject = null, $includeTrace = false) {
       $this->saveNewLogItem->addLogItem(new LogItem($logMessageString, $includeTrace, $logThisObject));
    }

    function loggHeader($logMessageString) {
       $this->saveNewLogItem->addLogItem(new LogItem("<h2>$logMessageString</h2>", null, false));
    }

    /**
     * echo the log to the output buffer
     *
     * @param boolean $doDumpSuperGlobals dump $_GET, $_POST etc
     */
   /* function echoLog($doDumpSuperGlobals = true) {
        global $logCollection;
        $logView = new \model\LoggingView($logCollection);
        echo $logView->getDebugData($doDumpSuperGlobals);
    }*/

    function getLogAllItems()
    {
        $getLogItems = new LogDAL();
        return $getLogItems->getAllLogItems();
    }

    public function getLogItemsByIP($ip){
        $getLogItemsByIP = new LogDAL();
        return $getLogItemsByIP->getAllLogItems();
    }
}