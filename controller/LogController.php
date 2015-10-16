<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-16
 * Time: 14:33
 */

namespace controller;

require_once("Logger.php");

class LogController
{



    function loggStuff() {
        loggHeader("A header");
        loggThis("write a message");
        loggThis("include call trace", null, true);
        loggThis("include an object", new \Exception("foo exception"), false);
    }


}