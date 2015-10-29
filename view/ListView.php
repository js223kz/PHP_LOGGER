<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-29
 * Time: 08:30
 */

namespace view;

use model\LogService;
require_once("view/ListView.php");

abstract class ListView
{

    private $logService;
    private $logItems = array();
    protected $ip = "ip";
    protected $microTime = "microtime";
    protected $sessionId = "sessionId";


    public function __construct(LogService $logService){
        $this->logService = $logService;
        $this->setLogItemsList();
    }

    private function getLogItemsCollection(){
        return $this->logService->getLogAllItems();
    }

    private function setLogItemsList(){
        foreach($this->getLogItemsCollection() as $logItem){
            array_push($this->logItems, [$this->ip => $logItem->m_ip, $this->microTime => $logItem->m_microTime, $this->sessionId => $logItem->m_sessionID]);
        }
    }

    protected function getLogItemsList(){
        return $this->logItems;
    }

    protected function checkIfUnique($valueToCheck, $arrayValue, $array)
    {
        foreach ($array as $value) {
            if ($value[$arrayValue] == $valueToCheck) {
                return false;
            }
        }
        return true;
    }

    protected function sortBy($field, &$array, $direction = 'desc')
    {
        usort($array, create_function('$a, $b', '
        $a = $a["' . $field . '"];
        $b = $b["' . $field . '"];

        if ($a == $b){
            return 0;
        }
        return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
    '));

        return true;
    }

    protected function convertMicroTime($microTime){
        list($usec, $sec) = explode(" ", $microTime);
        $sessionDate = date("Y-m-d H:i:s", $sec);
        return $sessionDate;
    }

    protected function renderHTML($title, $function)
    {
        echo '<!DOCTYPE html>
            <html>
            <head>
              <meta charset="utf-8">
              <title>Logger</title>
            </head>
            <body>
              <h1>Logger</h1>
              <h3>'.$title.'</h3>
              <div class="container">
                ' . $function . '
              </div>
             </body>
            </html>
        ';
    }

}