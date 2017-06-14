<?php
namespace Core\Exception;

/**
 * Représente une erreur de validation
 *
 * @package Core\Exception
 */
class ValidationException extends \Exception {

    /**
     * @var array
     */
    private $errors;

    public function __construct(array $errors)
    {

        $this->errors = $errors;
    }

    /**
     * Récupère la liste des erreurs
     *
     * @return array
     */
    public function getErrors (): array {
        return $this->errors;
    }

}