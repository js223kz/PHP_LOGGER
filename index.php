<?php
session_start();

require_once("Settings.php");
require_once("ini.php");
require_once("model/LogFacade.php");
require_once("controller/AdminController.php");

$logFacade = new \model\LogFacade();

$adminController = new \controller\AdminController($logFacade);
$data = new Settings();




