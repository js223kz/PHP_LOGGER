<?php
session_start();

require_once("Settings.php");
require_once("ini.php");
require_once("model/LogFacade.php");
require_once("controller/AdminController.php");
require_once("view/AdminView.php");

$logFacade = new \model\LogFacade();
$adminView = new \view\AdminView();

$adminController = new \controller\AdminController($logFacade, $adminView);
$data = new Settings();




