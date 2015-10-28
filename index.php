<?php
 session_start();
     /*session_unset();
     session_destroy();
     session_write_close();
     setcookie(session_name(),'',0,'/');
     session_regenerate_id(true);*/

require_once("Settings.php");
require_once("ini.php");
require_once("model/LogService.php");

require_once("controller/AdminController.php");
require_once("view/IPListView.php");

$logFacade = new \model\LogService();
$ipListView = new \view\IPListView();

$adminController = new \controller\AdminController($logFacade, $ipListView);
$data = new Settings();




