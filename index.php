<?php
session_start();

require_once("Settings.php");
require_once("ini.php");
require_once("model/LogService.php");
require_once("controller/AdminController.php");

$logService = new \model\LogService();

$adminController = new \controller\AdminController($logService);
$data = new Settings();




