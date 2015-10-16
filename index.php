<?php

require_once("Logger.php");
require_once("controller/LogController.php");

$logController = new \controller\LogController();

$logController->loggStuff();

//show log
//do not dump superglobals
echoLog(false);

//show with superglobals
echoLog();



