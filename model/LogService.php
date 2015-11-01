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

class LogService
{

    private $saveNewLogItem;

    public function __construct(){
        $this->saveNewLogItem = new LogDAL();
    }

    public function loggThis($logMessageString, $logThisObject = null, $includeTrace = false) {
       $this->saveNewLogItem->addLogItem(new LogItem($logMessageString, $includeTrace, $logThisObject));
    }

    public function loggHeader($logMessageString) {
       $this->saveNewLogItem->addLogItem(new LogItem("<h2>$logMessageString</h2>", null, false));
    }

    public function getAllLogItems()
    {
        $getLogItems = new LogDAL();
        return $getLogItems->getAllLogItems();
    }
}