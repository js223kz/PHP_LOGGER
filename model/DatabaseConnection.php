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

    /**
     * @return \mysqli
     * @throws \Exception
     */
    public function DbConnection(){

        $this->mysqli = new \mysqli(\Settings::HOST, \Settings::USERNAME, \Settings::PASSWORD,
                                    \Settings::DATABASENAME);
        if (mysqli_connect_errno()) {
            throw new \Exception( $this->mysqli->error);
        }
        return $this->mysqli;
    }
}