<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-28
 * Time: 14:49
 */

namespace view;

require_once("view/ListView.php");

/**
 * View that shows a list of unique sessions
 * for a specific ip-number
 */

class SessionListView extends ListView
{

    private $logSessions = array();
    private static $loggedDate = "loggedDate";
    private static $pageTitle = "Ip-address: ";
    private static $sessionURL = "session";


    //get list of unique session for that specific ip-number
    public function getSessionList($selectedIP)
    {
        $logItems = $this->getLogItemsList();

        foreach ($logItems as $logItem) {
            $latest = $this->getLatestSession($logItem[$this->sessionId], $logItems);
            if ($logItem[$this->ip] === $selectedIP) {
                if($this->checkIfUnique($logItem[$this->sessionId], $this->sessionId, $this->logSessions)){
                    array_push($this->logSessions, [$this->sessionId => $logItem[$this->sessionId], Self::$loggedDate => $latest]);
                }
            }
        }
        $this->sortBy(Self::$loggedDate, $this->logSessions);
        $this->renderHTML(Self::$pageTitle . $selectedIP, $this->renderSessionList());
    }

    /**
     * @param $sessionId
     * @param $logItems, array of ip-numbers, sessions, and dates
     * @return mixed
     * uses temporary array to sort session dates and get the latest logged
     */
    private function getLatestSession($sessionId, $logItems)
    {
        $sessionDateArray = array();

        foreach ($logItems as $logItem) {
            $dateTime = $this->convertMicroTime($logItem[$this->microTime]);
            if ($sessionId == $logItem[$this->sessionId]) {
                if (!in_array($dateTime, $sessionDateArray)) {
                    array_push($sessionDateArray, $dateTime);
                }
            }
        }
        return end($sessionDateArray);
    }
    /**
     * @return bool
     * checks if user clicked sessionlink
     * to view specific logged items in that session
     */
    public function sessionLinkIsClicked() {
        if (isset($_GET[self::$sessionURL]) ) {
            return true;
        }
        return false;
    }

    private function getSessionUrl($session) {
        return "?".self::$sessionURL."=$session";
    }

    public function getSession() {
        assert($this->sessionLinkIsClicked());
        return $_GET[self::$sessionURL];
    }

    /**
     * @return string that represents HTML for that list of sessions
     */
    private function renderSessionList()
    {
        $ret = "<ul>";
        foreach ($this->logSessions as $sessions) {
            $sessionId = $sessions[$this->sessionId];
            $lastLogged = $sessions[Self::$loggedDate];
            $sessionUrl = $this->getSessionUrl($sessions[$this->sessionId]);
            $ret .= "<li>Session: <a href='$sessionUrl'>$sessionId</a></li>";
            $ret .= "<li>Last logged: $lastLogged</li>";
            $ret .= "<br>";
        }
        $ret .= "</ul>";
        return $ret;
    }
}