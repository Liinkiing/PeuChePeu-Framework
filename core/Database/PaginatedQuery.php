<?php
namespace Core\Database;

use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;

/**
 * Permet de construire une requête paginée
 * @package App\Blog\Repository\Core\Database
 */
class PaginatedQuery implements AdapterInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $query;

    /**
     * @var int
     */
    private $count;

    /**
     * @param \PDO $pdo
     * @param string $query
     * @param int $count
     */
    public function __construct(\PDO $pdo, string $query, int $count)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->count = $count;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults()
    {
        return $this->count;
    }

    /**
     * Récupère une partie des résultat depuis la base de données
     *
     * @param int $offset
     * @param int $length
     * @return array
     */
    public function getSlice($offset, $length): array
    {
        return $this->pdo->query($this->query." LIMIT $offset, $length")->fetchAll();
    }

    /**
     * Renvoie les résultats sous forme d'instance de PagerFanta
     *
     * @return Pagerfanta
     */
    public function getPaginator(): Pagerfanta
    {
        return new Pagerfanta($this);
    }
}