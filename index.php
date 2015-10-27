<?php
 session_start();
     /*session_unset();
     session_destroy();
     session_write_close();
     setcookie(session_name(),'',0,'/');
     session_regenerate_id(true);*/

require_once("Settings.php");
require_once("ini.php");
require_once("model/LogFacade.php");

require_once("controller/AdminController.php");
require_once("view/AdminView.php");

$logFacade = new \model\LogFacade();
$adminView = new \view\AdminView();

$adminController = new \controller\AdminController($logFacade, $adminView);
$data = new Settings();




