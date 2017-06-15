<?php

namespace Core\Database;

class Database
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

    public function __construct($database, $username = 'root', $password = 'root', $host = 'localhost')
    {
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
    }

    /**
     * Lazy load la connexion PDO au besoin.
     *
     * @return \PDO
     */
    public function getPDO(): \PDO
    {
        if (!$this->pdo) {
            $this->pdo = new \PDO("mysql:host={$this->host};dbname={$this->database}",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]
            );
        }

        return $this->pdo;
    }

    /**
     * Permet de récupérer un enregistrement depuis la base de données.
     *
     * @param string      $query
     * @param array       $params
     * @param string|null $entity
     *
     * @return mixed
     */
    public function fetch(string $query, array $params = [], string $entity = null)
    {
        return $this->createQuery($query, $params, $entity)->fetch();
    }

    /**
     * Récupère plusieurs enregistrements depuis la base de données.
     *
     * @param string      $query
     * @param array       $params
     * @param string|null $entity
     *
     * @return array
     */
    public function fetchAll(string $query, array $params = [], string $entity = null): array
    {
        return $this->createQuery($query, $params, $entity)->fetchAll();
    }

    /**
     * Récupère une colonne.
     *
     * @param string      $query
     * @param array       $params
     * @param string|null $entity
     *
     * @return string
     */
    public function fetchColumn(string $query, array $params = [], string $entity = null): string
    {
        return $this->createQuery($query, $params, $entity)->fetchColumn();
    }

    /**
     * Génère une requête PDO.
     *
     * @param string      $query
     * @param array       $params
     * @param string|null $entity
     *
     * @return \PDOStatement
     */
    private function createQuery(string $query, array $params = [], string $entity = null): \PDOStatement
    {
        if (count($params) === 0) {
            $query = $this->getPDO()->query($query);
        } else {
            $query = $this->getPDO()->prepare($query);
            $query->execute($params);
        }
        if ($entity) {
            $query->setFetchMode(\PDO::FETCH_CLASS, $entity);
        }

        return $query;
    }
}
