<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:10
 */

namespace model;

require_once('DatabaseConnection.php');

class LogDAL
{
    private static $databaseTable = "logitem";
    private $database;
    private $dbConnection;
    private $logItems = array();

    public function __construct(){
        $this->database = new DatabaseConnection();
        $this->dbConnection = $this->database->DbConnection();

    }

    public function getAllLogItems(){
        $stmt = $this->dbConnection->prepare("SELECT * FROM " . self::$databaseTable);
        if ($stmt === FALSE) {
            throw new \Exception($this->database->error);
        }
        $stmt->execute();

        $stmt->bind_result($session, $ip, $object, $backtrace, $calledfrom, $microtime, $message);
        while ($stmt->fetch()) {
            $logItem = new LogItem();
            $this->logItems->add($logItem);
        }
        return  $this->logItems;
    }

   public function AddLogItem($newLogCollection){

        //var_dump($newLogCollection);

       $sessionID = session_id();
       $ip = $_SERVER['REMOTE_ADDR'];
       $logitem = serialize($newLogCollection);

       var_dump($logitem);

       $stmt = $this->dbConnection->prepare("INSERT INTO `logitem` (`ip` , `sessionid`, `logitemobject`) VALUES (?, ?, ?)");
       if ($stmt === FALSE) {
           throw new \Exception($this->database->error);
       }

       $stmt->bind_param('sss', $ip, $sessionID, $logitem);
       $stmt->execute();

        /*$stmt = $this->dbConnection->prepare("INSERT INTO `logitem` (`sessionid` , `ip`,
                                    `object`, `backtrace`, `calledfrom`, `microtime`, `message`)
				                      VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === FALSE) {
                throw new \Exception($this->database->error);
            }

        $session = $newLogItem->m_sessionID;
        $ip = $newLogItem->m_ip;
        $object = serialize($newLogItem->m_object);
        $backtrace = $newLogItem->m_debug_backtrace;
        $calledfrom = $newLogItem->m_calledFrom;
        $microtime = $newLogItem->m_microTime;
        $message = $newLogItem->m_message;

        $stmt->bind_param('sssbsss', $session, $ip, $object, $backtrace, $calledfrom, $microtime, $message);
        $stmt->execute();*/
    }
}


//INSERT INTO `logitem`(`sessionid`, `ip`, `object`, `backtrace`, `calledfrom`, `mictrotime`, `message`)
//VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])