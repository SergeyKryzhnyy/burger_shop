<?php
class Db
{
    private static $instance;
    /** @var /PDO */
    private $pdo;
    private $log;

    private function __construct()
    {
    }

    private  function __clone()
    {
        //TODO: Implement __clone() method
    }

    public static  function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect()
    {
        if (!$this->pdo)
        {
            $this->pdo = new PDO("mysql:host=localhost:3307;dbname=users_data;charset=utf8","admin","12345");
        }
        return $this->pdo;
    }

    public function exec(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);
        $t = microtime(1) - $t;

        if (!$ret)
        {
            if ($query->errorCode())
            {
                trigger_error($query->errorInfo());
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];
        return $query->rowCount();
    }

    public function lastInsertId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }

    public function getLog()
    {
        return $this->log;
    }

    public function fetchAll(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);
        $t = microtime(1) - $t;

        if (!$ret)
        {
            if ($query->errorCode())
            {
                trigger_error($query->errorInfo());
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];
        $result =  $query->fetchAll($this->pdo::FETCH_ASSOC);
        return $result;
    }

    public function fetchOne(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $query = $this->pdo->prepare($query);
        $ret = $query->execute($params);
        $t = microtime(1) - $t;

        if (!$ret)
        {
            if ($query->errorCode())
            {
                trigger_error($query->errorInfo());
            }
            return false;
        }

        $this->log[] = ['query' => $query, 'time' => $t, 'method' => $method];
        $result =  $query->fetchAll($this->pdo::FETCH_ASSOC);
        foreach ($result as $res)
        {
            $ress = $res;
        }
        return $ress;
    }
}