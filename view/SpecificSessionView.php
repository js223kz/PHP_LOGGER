<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-29
 * Time: 12:40
 */

namespace view;

/**
 * View that shows all logItems in a specific session
 */
class SpecificSessionView extends ListView
{
    private static $pageTitle = "SessionId: ";

    public function getSpecificSessionList($sessionId){
        $title = Self::$pageTitle . $sessionId;
        $this->renderHTML($title, $this->getSessionData($sessionId));
    }

    /**
     * @param $sessionId
     * @return string that represents html for all logged items
     */
    public function getSessionData($sessionId){

        $logItems = $this->getLogItemsCollection();
        $debugItems = "";

        foreach($logItems as $logitem){
            if($logitem->m_sessionID === $sessionId) {
                $debugItems .= $this->showLogItem($logitem);
            }
        }
        $html = "
            <div>
                <hr/>
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
        return $html;
    }

    /**
     * @param LogItem $item
     * @return string HTML
     */
    private function showLogItem($logItem)
    {
        if ($logItem->m_debug_backtrace != null) {
                $debug = "<h4>Trace:</h4>
					 <ul>";
                foreach ($logItem->m_debug_backtrace AS $key => $row) {

                    //the two topmost items are part of the logger
                    //skip those
                    if ($key < 2) {
                        continue;
                    }
                    $key = $key - 2;
                    $debug .= "<li> $key " . LogItem::cleanFilePath($row['file']) . " Line : " . $row["line"] . "</li>";
                }
                $debug .= "</ul>";
            } else {
                $debug = "";
            }

            if ($logItem->m_object != null) {
                $object = print_r($logItem->m_object, true);
            } else {
                $object = "";
            }

            $date = $this->convertMicroTime($logItem->m_microTime);
            $ret = "<li>
					<strong>$logItem->m_message </strong> $logItem->m_calledFrom
					<div style='font-size:small'>$date</div>
					<pre>$object</pre>

					$debug

				</li>";

            return $ret;
        }

}