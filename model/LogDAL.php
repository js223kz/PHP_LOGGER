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
    private static $databaseTable = "logitems";
    private $database;
    private $dbConnection;


    public function __construct(){
        try{
            $this->database = new DatabaseConnection();
            $this->dbConnection = $this->database->DbConnection();
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return array with logItem objects
     * @throws \Exception
     */
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

    /**
     * @param LogItem $newLogItem
     * @throws \Exception
     */
   public function addLogItem(LogItem $newLogItem){
        $logitem = serialize($newLogItem);

       $query = $this->dbConnection->prepare("INSERT INTO `logitems` (`logitem`)
                                          VALUES (?)");
       if ($query === FALSE) {
           throw new \Exception($this->database->error);
       }

       $query->bind_param('s', $logitem);
       $query->execute();
    }
}
