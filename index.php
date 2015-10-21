<?php
session_start();

require_once("Settings.php");
require_once("ini.php");
require_once("controller/AdminController.php");

$adminController = new \controller\AdminController();
$data = new Settings();




