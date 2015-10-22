<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-22
 * Time: 14:10
 */

namespace view;


use model\LogFacade;
require_once("model/LogItem.php");

class adminView
{


    public function showIPList(LogFacade $logFacade){
        $logItems = array();
        $items = $logFacade->getLogAllItems();
        $latestItem = microtime();

        foreach($items as $key => $item) {
            array_push($logItems, $item->m_ip);

        }
        var_dump($logItems);
        foreach($logItems as $sessionid){
            $str = (string)$sessionid;
            $count = array_count_values($logItems);
            $num = $count[$sessionid];
        }
    }
}

//if(!in_array($item->m_ip, $logItems)){

//}