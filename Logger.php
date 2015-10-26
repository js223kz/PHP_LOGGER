<?php
//This has no namespace for convenience, it should really be a common module
require_once("model/LogCollection.php");
require_once("model/LogDAL.php");
require_once("model/LogItem.php");
require_once("view/LogView.php");


//uses globals for convenience
//to let us avoid create and use an object...
//$logCollection = new model\LogCollection();

/**
* Logging Method
* @param string $logMessageString The message you intend to log
* @param mixed $logThisObject An object which state you want to log 
* @param boolean $includeTrace save callstack
* @return void
*/
private $saveNewLogItem;

public function __construct(){
	$this->saveNewLogItem = new model\LogDAL();
}
function loggThis($logMessageString, $logThisObject = null, $includeTrace = false) {

	$this->saveNewLogItem->AddLogItem(new \model\LogItem($logMessageString, $includeTrace, $logThisObject));
	//global $logCollection;
	//$logCollection->log($logMessageString, $includeTrace, $logThisObject);
}

/**
* Logging Method
* Shows a header item in the log
* @param string $logMessageString The message you intend to log
* @return void
*/
function loggHeader($logMessageString) {
	//global $logCollection;
	//$logCollection->log("<h2>$logMessageString</h2>", null, false);
	$this->saveLogItems->AddLogItem(new \model\LogItem("<h2>$logMessageString</h2>", null, false));
}

/**
* echo the log to the output buffer
* 
* @param boolean $doDumpSuperGlobals dump $_GET, $_POST etc
*/
/*function echoLog($doDumpSuperGlobals = true) {
	global $logCollection;
	$logView = new \model\LogView($logCollection);
	echo $logView->getDebugData($doDumpSuperGlobals);
}*/

function getLogAllItems(){
	$getLogItems = new \model\LogDAL();

	return $getLogItems->getAllLogItems();
}