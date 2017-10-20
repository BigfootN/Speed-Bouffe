<?php

namespace SpeedBouffe\Database;

require 'LoginFile.php';

use \PDO;

class DatabaseN
{

    /**
     * @var PDO
     */
    private $dbh;

    /**
     * @var LoginFile
     */
    private $login_file;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $dbname;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $password;


    /**
     * @param LoginFile
     */
    private function setLoginInfo($login_file)
    {
        $this->user     = $login_file->getUser();
        $this->password = $login_file->getPassword();
        $this->host     = $login_file->getHost();
        $this->dbname   = $login_file->getDatabase();

    }//end setLoginInfo()


    /**
     * @return void
     */
    private function initConn()
    {
        $dsn = 'mysql:dbname='.$this->dbname.';host='.$this->host;

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: '.$e->getMessage();
        }

    }//end initConn()


    /**
     * @param string $login_file_path
     */
    public function __construct($login_file_path)
    {
        $this->login_file = new LoginFile($login_file_path);

        $this->setLoginInfo($this->login_file);
        $this->initConn();

    }//end __construct()


    /**
     * @return PDO
     */
    public function getPDO()
    {
        return $this->dbh;

    }//end getPDO()


    /**
     * @param string $sql
     * @param array  $attributes
     * @param string $class_name
     */
    public function prepare($sql, $attributes, $class_name, $one=false)
    {
        try {
            $req = $this->dbh->prepare($sql);
        } catch (PDOException $e) {
            echo 'PDO Exception : '.$e->getMessage();
        }

        $res = $req->execute($attributes);
        if (strpos($sql, 'UPDATE') === 0 || strpos($sql, 'INSERT') === 0 || strpos($sql, 'DELETE') === 0) {
            return $res;
        }

        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if ($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }

        return $datas;

    }//end prepare()


    public function exec($sql)
    {
        $req = $this->getPDO()->exec($sql);
        return $req;

    }//end exec()


    public function getLastId($name)
    {
        return $this->getPDO()->lastInsertId($name);

    }//end getLastId()


}//end class
