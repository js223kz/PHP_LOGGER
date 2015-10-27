<?php

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

    public function getIPList(LogFacade $logFacade){
        $this->setIPList($logFacade);
    }


    private function setIPList(LogFacade $logFacade)
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
        $this->renderHTML();
    }

    private function checkIfIPUnique($item){
        $found = false;

        foreach($this->logItems as $value){
            if($value[Self::$ip] == $item->m_ip){
                //this value doesn´t change. If Ipaddress is already in the array
                // I want to replace mictrotime of that element to
                //the latest $item microtime since that is the latter of the two
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

    private function getOccurances(){
        $count = array_count_values($this->ipaddresses);
        for($i=0; $i < count($this->logItems); $i++){
            $num = $count[$this->logItems[$i][Self::$ip]];
            $this->logItems[$i][Self::$numberOfTimes] = $num;
        }
    }

    private function renderHTML(){
        echo '<!DOCTYPE html>
            <html>
            <head>
              <meta charset="utf-8">
              <title>Login Example</title>
            </head>
            <body>
              <h1>Logger</h1>
              <div class="container">
                ' .$this->renderIPList(). '
              </div>
             </body>
            </html>
        ';
    }


    private function renderIPList(){
        $ret = "<h3>Logged Ip addresses</h3>

				<ul>";
        foreach ($this->logItems as $ipAdresses) {
            $ip = $ipAdresses[Self::$ip];
            $occurrences = $ipAdresses[Self::$numberOfTimes];
            list($date, $sec) = explode(" ", $ipAdresses[Self::$microTime]);
            $date = date("Y-m-d H:i:s", $sec);
            $ret .= "<li>$ip</li>";
            $ret .= "<li>Number of times:  $occurrences</li>";
            $ret .= "<li>Logged latest at:  $date</li>";
            $ret .="<br>";
        }
        $ret .= "</ul>";
        return $ret;
    }
}
