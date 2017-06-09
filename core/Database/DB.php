<?php
namespace Core\Database;

class DB
{

    public $database;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $host;

    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct($database, $username = "root", $password = "root", $host = "localhost")
    {
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
    }

    public function getPDO(): \PDO
    {
        if (!$this->pdo) {
            $this->pdo = new \PDO("mysql:host={$this->host};dbname={$this->database}",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]
            );

        }
        return $this->pdo;
    }

}