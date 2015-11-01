<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-29
 * Time: 08:30
 */

namespace view;

use model\LogService;

//Baseclass that implements methods and variables
//used in views to avoid duplicated code
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

    /**
     * @return array with LogItem objects from database
     */
    public function getLogItemsCollection(){
        return $this->logService->getAllLogItems();
    }

    /**
     * To avoid looping through unneccesary data in views
     *this method sets a list with just the required data
    */
    private function setLogItemsList(){
        foreach($this->getLogItemsCollection() as $logItem){
            array_push($this->logItems, [$this->ip => $logItem->m_ip, $this->microTime => $logItem->m_microTime, $this->sessionId => $logItem->m_sessionID]);
        }
    }

    /**
     * @return array with required LogItem data
     */
    protected function getLogItemsList(){
        return $this->logItems;
    }

    /**
     * Checks if either ip number or sessionId is unique
    (depending on which view is calling the method)
     * */
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

    /*
     * converts microtime to readable string
     */
    protected function convertMicroTime($microTime){
        list($usec, $sec) = explode(" ", $microTime);
        $sessionDate = date("Y-m-d H:i:s", $sec);
        return $sessionDate;
    }

    /*
     * renders overall layout
     */
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