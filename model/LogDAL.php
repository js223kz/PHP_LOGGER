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


    public function __construct(){
        $this->database = new DatabaseConnection();
        $this->dbConnection = $this->database->DbConnection();

    }

    public function getAllLogItems(){
        $logItems = array();
        $stmt = $this->dbConnection->prepare("SELECT * FROM " . self::$databaseTable);
        if ($stmt === FALSE) {
            throw new \Exception($this->database->error);
        }
        $stmt->execute();

        $stmt->bind_result($id, $object);
        while ($stmt->fetch()) {
            $newObject = unserialize($object);
            var_dump($id);
            array_push($logItems, [$id => $newObject]);
        }
        return $logItems;
    }

   public function AddLogItem(LogItem $newLogItem){

       $logitem = serialize($newLogItem);

       $stmt = $this->dbConnection->prepare("INSERT INTO `logitem` (`logitemobject`) VALUES (?)");
       if ($stmt === FALSE) {
           throw new \Exception($this->database->error);
       }

       $stmt->bind_param('s', $logitem);
       $stmt->execute();
    }
}
