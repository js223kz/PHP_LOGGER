<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:10
 */

namespace model;

require_once('DatabaseConnection.php');
include("model/LogItem.php");
class LogDAL
{
    private static $databaseTable = "logitem";
    private $database;
    private $dbConnection;


    public function __construct(){
        $this->database = new DatabaseConnection();
        $this->dbConnection = $this->database->DbConnection();
    }

    public function getAllLogItems(){
        $logItems = array();
        $query = $this->dbConnection->prepare("SELECT * FROM " . self::$databaseTable);
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->execute();

        $query->bind_result($id, $object);
        while ($query->fetch()) {
            $logItem = unserialize($object);
            array_push($logItems, $logItem);
        }
        return $logItems;
    }

   public function AddLogItem(LogItem $newLogItem){
        $logitem = serialize($newLogItem);

       $query = $this->dbConnection->prepare("INSERT INTO `logitem` (`logitem`)
                                          VALUES (?)");
       if ($query === FALSE) {
           throw new \Exception($this->database->error);
       }

       $query->bind_param('s', $logitem);
       $query->execute();
    }
}
/*public function getAllLogItems(){
    $logItems = array();
    $query = $this->dbConnection->prepare("SELECT * FROM " . self::$databaseTable);
    if ($query === FALSE) {
        throw new \Exception($this->database->error);
    }
    $query->execute();

    $query->bind_result($id, $message, $session, $ip, $calledfrom, $microtime, $backtrace, $object);
    while ($query->fetch()) {
        $o = unserialize($object);
        $c = unserialize($calledfrom);
        array_push($logItems,$message,$session,$ip,$c,$microtime,$backtrace,$o);
    }
    return $logItems;
}

public function AddLogItem(LogItem $newLogItem){
    $logitem = serialize($newLogItem);

    $query = $this->dbConnection->prepare("INSERT INTO `logitem` (`message`, `sessionid`,`ip`,`calledfrom`,`microtime`,`backtrace`,`object`)
                                          VALUES (?,?,?,?,?,?,?)");
    if ($query === FALSE) {
        throw new \Exception($this->database->error);
    }

    $message = $newLogItem->m_message;
    $session = $newLogItem->m_sessionID;
    $ip = $newLogItem->m_ip;
    $calledfrom = serialize($newLogItem->m_calledFrom);
    $microtime = $newLogItem->m_microTime;
    $backtrace = $newLogItem->m_debug_backtrace;
    $object = serialize($newLogItem->m_object);

    $query->bind_param('sssssss', $message,$session,$ip,$calledfrom,$microtime,$backtrace,$object);
    $query->execute();
}*/