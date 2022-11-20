<?php

class DB {
    private static $host = 'db';
    private static $db = 'db';
    private static $user = 'root';
    private static $password = 'root';
    static $prefix = '';

    private $dbconn;
    private static $instance;
    private function __construct(string $host, string $db, string $user, string $password) {
        $this->dbconn = new PDO(
            'mysql:host='.$host.';dbname='.$db,
            $user,
            $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
        );
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    public static function get() {
        if (!self::$instance) {
            self::$instance = new self(
                self::$host,
                self::$db,
                self::$user,
                self::$password
            );
        }
        return self::$instance;
    }

    public function insert(string $query, $param) {
        $sth = $this->dbconn->prepare($query);
        $this->bindValues($sth, $param);
        return ($sth->execute() ? $this->dbconn->lastInsertId() : 0);
    }

    public function query(string $query, $param) {
        $sth = $this->dbconn->prepare($query);
        $this->bindValues($sth, $param);
        return $sth->execute();
    }

    public function getRow($query, $param = array())
    {
        $sth = $this->dbconn->prepare($query);
        $this->bindValues($sth, $param);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($query, $param = array()) {
        $sth = $this->dbconn->prepare($query);
        $this->bindValues($sth, $param);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getValue($query, $param = array(), $default = null) {
        $result = $this->getRow($query, $param);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    public function getWithMode($mode, $query, $param = array()) {
        if ($mode === 'all') {
            return $this->getAll($query, $param);
        } else if ($mode === 'row') {
            return $this->getRow($query, $param);
        } else if ($mode === 'value') {
            return $this->getValue($query, $param);
        }
    }

    private function bindValues($sth, $param) {
        foreach ($param as $key => $value) {
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }

            if (is_int($key)) {
                $key++;
            } else {
                $key = ':' . $key;
            }
            $sth->bindValue($key, $value, $type);
        }
    }

    public function lastInsertID(): string {
        return $this->dbconn->lastInsertId();
    }
}