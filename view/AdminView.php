<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-22
 * Time: 14:10
 */

namespace view;


use model\LogFacade;
require_once("model/LogItem.php");

class adminView
{

    private static $ip = "ip";
    private static $microTime = "microtime";
    private static $numberOfTimes = "numberOfTimes";
    private $logItems = array();
    private $ipaddresses = array();


    public function getIPList(LogFacade $logFacade)
    {

        //returning array of LogItem objects
        $items = $logFacade->getLogAllItems();

        foreach ($items as $key => $item) {
            array_push($this->ipaddresses, $item->m_ip);
            if($this->logItems == null){
                array_push($this->logItems, [Self::$ip => $item->m_ip, Self::$microTime => $item->m_microTime]);
            }
            if($this->logItems != null){
                $this->checkIfIPUnique($item);
                $this->getOccurances();
            }
        }

        var_dump($this->logItems);
    }

    private function getOccurances(){
        $count = array_count_values($this->ipaddresses);
        for($i=0; $i < count($this->logItems); $i++){
            $num = $count[$this->logItems[$i][Self::$ip]];
            $this->logItems[$i][Self::$numberOfTimes] = $num;
        }
    }

    private function checkIfIPUnique($item){
        $found = false;

        foreach($this->logItems as $value){
            if($value[Self::$ip] == $item->m_ip){
                $value[Self::$microTime] = $item->m_microTime;
                $found = true;
            }else{
                $found = false;
            }
        }
        if($found != true){
            array_push($this->logItems, [Self::$ip => $item->m_ip, Self::$microTime => $item->m_microTime]);
        }
    }
}


//list($usec, $sec) = explode(" ", $item->m_microTime);
//$date = date("Y-m-d H:i:s", $sec);