<?php

namespace controller;

require_once('view/LoggingView.php');

class LogController
{
    private $adminLoggerView;
    public function __construct(){

        $this->adminLoggerView = new \view\LoggingView();
        var_dump("hello");

    }

   function loggStuff() {
        loggHeader("A header");
        loggThis("write a message");
        loggThis("include call trace", null, true);
        loggThis("include an object", new \Exception("foo exception"), false);
    }


}