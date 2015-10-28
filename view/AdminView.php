<?php

namespace view;

use model\LogFacade;

require_once("model/LogItem.php");

class adminView
{

    private static $ip = "ip";
    private static $microTime = "microtime";
    private static $numberOfTimes = "numberOfTimes";
    private $listItems = array();


    /**
     * @param $logFacade interacts between models and controller
     * gets all objects from database and creates array with
     * data to show in list
     */

    public function getIPList(LogFacade $logFacade)
    {
        //returning array of LogItem objects
        $logItems = $logFacade->getLogAllItems();

        foreach ($logItems as $logItem) {

            $num = $this->getNumberOfSessions($logItem->m_ip, $logItems);
            $latest = $this->getLatestSession($logItem->m_ip, $logItems);

            if ($this->checkIfIPUnique($logItem)) {
                array_push($this->listItems, [Self::$ip => $logItem->m_ip, Self::$microTime => $latest, Self::$numberOfTimes => $num]);
            }
        }
        //sorting array so last logged ipadress comes first
        $this->sortBy(Self::$microTime,   $this->listItems);

        $this->renderHTML();
    }

    /**
     * @param $ipToCheck , particular ip-address
     * @param $logItems , array with LogItem objects
     * @return last item in array which is the latest date
     * of logged session for one particular ipaddress
     * this function runs for each LogItem object stored in database
     */
    private function getLatestSession($ipToCheck, $logItems)
    {
        $sessionDateArray = array();

        foreach ($logItems as $logItem) {
            //create readable datestring from microtime
            list($usec, $sec) = explode(" ", $logItem->m_microTime);
            $sessionDate = date("Y-m-d H:i:s", $sec);

            if ($ipToCheck == $logItem->m_ip) {
                if (!in_array($sessionDate, $sessionDateArray)) {
                    array_push($sessionDateArray, $sessionDate);
                }
            }
        }
        return end($sessionDateArray);
    }

    /**
     * @param $ipToCheck , particular ip-address
     * @param $logItems , $items array with LogItem objects
     * @return int, number of unique sessionid´s
     * for a particular ip-address
     */
    private function getNumberOfSessions($ipToCheck, $logItems)
    {
        $sessionArray = array();

        foreach ($logItems as $logItem) {
            if ($ipToCheck == $logItem->m_ip) {
                if (!in_array($logItem->m_sessionID, $sessionArray)) {
                    array_push($sessionArray, $logItem->m_sessionID);
                }
            }
        }
        return count($sessionArray);
    }

    /**
     * @param $logItem , one particular LogItem objects
     * @return bool if ip-address is not already i list to show
     */
    private function checkIfIPUnique($logItem)
    {

        foreach ($this->listItems as $value) {
            if ($value[Self::$ip] == $logItem->m_ip) {
                return false;
            }
        }
        return true;
    }


    private function renderHTML()
    {
        echo '<!DOCTYPE html>
            <html>
            <head>
              <meta charset="utf-8">
              <title>Login Example</title>
            </head>
            <body>
              <h1>Logger</h1>
              <div class="container">
                ' . $this->renderIPList() . '
              </div>
             </body>
            </html>
        ';
    }


    private function renderIPList()
    {
        $ret = "<h3>Logged Ip addresses</h3>

				<ul>";
        foreach ($this->listItems as $ipAdresses) {
            $ip = $ipAdresses[Self::$ip];
            $occurrences = $ipAdresses[Self::$numberOfTimes];
            $time = $ipAdresses[Self::$microTime];


            $ret .= "<li>IP-address: $ip</li>";
            $ret .= "<li>Number of sessions:  $occurrences</li>";
            $ret .= "<li>Logged latest at:  $time</li>";
            $ret .= "<br>";
        }
        $ret .= "</ul>";
        return $ret;
    }

    function sortBy($field, &$array, $direction = 'desc')
    {
        usort($array, create_function('$a, $b', '
        $a = $a["' . $field . '"];


        $b = $b["' . $field . '"];

        if ($a == $b)
        {
            return 0;
        }

        return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
    '));

        return true;
    }
}
