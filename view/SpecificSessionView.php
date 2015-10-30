<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-29
 * Time: 12:40
 */

namespace view;


use model\LogService;

class SpecificSessionView
{
    private $logList = array();
    private static $ip = "ip";
    private static $message = "message";
    private static $sessionId = "session";
    private static $object = "object";
    private static $backtrace = "backtrace";
    private static $calledFrom = "calledFrom";
    private static $microtime = "microtime";

    public function getSessionData($sessionId, LogService $logService){
        var_dump($sessionId);

        $logItems = $logService->getLogAllItems();
        $debugItems = "";
       foreach($logItems as $logitem){
           //$debugItems .= $this->showDebugItem($logitem);

            if($logitem->m_sessionID == $sessionId){
                var_dump($logitem->m_message);
                var_dump($logitem->m_message);
                echo ($logitem->m_object);
                $dumps = "
			<div>
				<hr/>
				<h2>Debug</h2>
				<table>
					<tr>
				   		<td>
				   			<h3>Debug Items</h3>
				   			<ol>
				   				$debugItems
				   			</ol>
					 	</td>
					</tr>
			    </table>
		    </div>";
                return $dumps;
               /* array_push($this->logList, [
                    Self::$message => $logitem->m_message,
                    Self::$microtime => $logitem->m_microTime,
                    Self::$object => $logitem->m_object,
                    Self::$backtrace => $logitem->m_debug_backtrace,
                    Self::$calledFrom => $logitem->m_calledFrom
                ]);*/
            }
        }
        var_dump($this->logList);
    }


    /**
     * @param LogItem $item
     * @return string HTML
     */
    private function showDebugItem(LogItem $item) {

        if ($item->m_debug_backtrace != null) {
            $debug = "<h4>Trace:</h4>
					 <ul>";
            foreach ($item->m_debug_backtrace AS $key => $row) {

                //the two topmost items are part of the logger
                //skip those
                if ($key < 2) {
                    continue;
                }
                $key = $key - 2;
                $debug .= "<li> $key " . LogItem::cleanFilePath($row['file']) . " Line : " . $row["line"] .  "</li>";
            }
            $debug .= "</ul>";
        } else {
            $debug = "";
        }

        if ($item->m_object != null)
            $object = print_r($item->m_object, true);
        else
            $object = "";
        list($usec, $sec) = explode(" ", microtime());

        $date = date("Y-m-d H:i:s", $sec);
        $ret =  "<li>
					<Strong>$item->m_message </strong> $item->m_calledFrom
					<div style='font-size:small'>$date $usec</div>
					<pre>$object</pre>

					$debug

				</li>";

        return $ret;
    }
}