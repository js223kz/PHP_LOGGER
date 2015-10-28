<?php

namespace view;

use model\LogService;

require_once("model/LogItem.php");

class IPListView
{

    private static $ip = "ip";
    private static $microTime = "microtime";
    private static $numberOfTimes = "numberOfTimes";
    private static $ipURL = "ip";
    private $listItems = array();


    /**
     * @param $logFacade interacts between models and controller
     * gets all objects from database and creates array with
     * data to show in list
     */

    public function getIPList(LogService $logService)
    {
        //returning array of LogItem objects
        $logItems = $logService->getLogAllItems();

        foreach ($logItems as $logItem) {

            $num = $this->getNumberOfSessions($logItem->m_ip, $logItems);
            $latest = $this->getLatestSession($logItem->m_ip, $logItems);

            if ($this->checkIfIPUnique($logItem->m_ip)) {
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
    private function checkIfIPUnique($ip)
    {

        foreach ($this->listItems as $value) {
            if ($value[Self::$ip] == $ip) {
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
              <title>Logger</title>
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
            $ipUrl = $this->getIPUrl($ip);


            $ret .= "<li>IP-address: <a href='$ipUrl'>$ip</a></li>";
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

    public function getIPUrl($ip) {
        return "?".self::$ipURL."=$ip";
    }

    public function ipLinkIsClicked() {
        if (isset($_GET[self::$ipURL]) ) {
            return true;
        }
        return false;
    }
    public function getProductID() {
        assert($this->ipLinkIsClicked());
        return $_GET[self::$ipURL];
    }
}
