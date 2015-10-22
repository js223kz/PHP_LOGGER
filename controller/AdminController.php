<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-21
 * Time: 08:36
 */

namespace controller;

require_once('model/LogItem.php');
require_once('model/LogDAL.php');
require_once('model/LogCollection.php');
require_once('model/DatabaseConnection.php');
require_once("Logger.php");

class AdminController
{

    public function __construct(){
        $this->loggStuff();

        saveLog();
        echoLog(false);

    }

    public function loggStuff() {
    loggHeader("A header");
    loggThis("write a message");
    loggThis("include call trace", null, true);
    loggThis("include an object", new \Exception("foo exception"), false);
    }

}

//show log
//do not dump superglobals
//echoLog(false);

//show with superglobals
//echoLog();
