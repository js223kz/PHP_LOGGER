<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-10-20
 * Time: 16:58
 */

namespace model;

class DatabaseConnection
{

    private $mysqli;
    public function DbConnection(){

        $this->mysqli = new \mysqli(\Settings::HOST, \Settings::USERNAME, \Settings::PASSWORD,
                                    \Settings::DATABASENAME, 8889);
        if (mysqli_connect_errno()) {
            throw new \Exception( $this->mysqli->error);
            exit();
        }
        return $this->mysqli;
    }
}