<?php

namespace App\Blog\Validator;

use Cake\Validation\Validator;

/**
 * Permet de valider un article.
 */
class PostValidator
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    public $errors;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Valide les données.
     *
     * @return bool
     */
    public function validates(): bool
    {
        $validator = new Validator();
        $validator->requirePresence(['name', 'content', 'created_at']);
        $validator->minLength('name', 4);
        $validator->minLength('content', 20);
        $validator->dateTime('created_at');
        $this->errors = $validator->errors($this->params);

        return count($this->errors) === 0;
    }
}
