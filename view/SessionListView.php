<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-28
 * Time: 14:49
 */

namespace view;


use model\LogService;

class SessionListView
{

    private $logSessions = array();
    private static $sessionID = "sessionId";
    private static $loggedDate = "loggedDate";

    public function getSessionList($selectedIP, LogService $logService)
    {
        $logItems = $logService->getLogAllItems();

        foreach ($logItems as $logItem) {
            $latest = $this->getLatestSession($logItem->m_sessionID, $logItems);
            if ($logItem->m_ip === $selectedIP) {
                if($this->checkIfSessionUnique($logItem->m_sessionID)){
                    array_push($this->logSessions, [Self::$sessionID => $logItem->m_sessionID, Self::$loggedDate => $latest]);
                }
            }
        }
        //var_dump($this->logSessions);
        $this->renderHTML($selectedIP);
    }

    private function checkIfSessionUnique($session)
    {

        foreach ($this->logSessions as $value) {
            if ($value[Self::$sessionID] == $session) {
                return false;
            }
        }
        return true;
    }

    private function getLatestSession($sessionId, $logItems)
    {
        $sessionDateArray = array();

        foreach ($logItems as $logItem) {
            //create readable datestring from microtime
            list($usec, $sec) = explode(" ", $logItem->m_microTime);
            $sessionDate = date("Y-m-d H:i:s", $sec);

            if ($sessionId == $logItem->m_sessionID) {
                if (!in_array($sessionDate, $sessionDateArray)) {
                    array_push($sessionDateArray, $sessionDate);
                }
            }
        }
        return end($sessionDateArray);
    }

    private function renderHTML($selectedIP)
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
                ' . $this->renderSessionList($selectedIP) . '
              </div>
             </body>
            </html>
        ';
    }

    private function renderSessionList($selectedIP)
    {
        $ret = "<h3>IP-address: $selectedIP</h3>

				<ul>";
        foreach ($this->logSessions as $sessions) {
            $sessionId = $sessions[Self::$sessionID];
            $lastLogged = $sessions[Self::$loggedDate];
            //$ipUrl = $this->getIPUrl($session);
            $ret .= "<li>Session: <a href=''>$sessionId</a></li>";
            $ret .= "<li>Last logged: $lastLogged</li>";
            $ret .= "<br>";
        }
        $ret .= "</ul>";
        return $ret;
    }
}