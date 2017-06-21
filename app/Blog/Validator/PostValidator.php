<?php

namespace App\Blog\Validator;

use Cake\Validation\Validator;

/**
 * Permet de valider un article.
 */
class PostValidator
{
    /**
     * Valide les données.
     *
     * @param array $params
     *
     * @return array
     */
    public static function validates(array $params, bool $forceImage = false): array
    {
        $validator = new Validator();
        $validator->requirePresence(['name', 'content', 'created_at']);
        $validator->minLength('name', 4);
        $validator->minLength('content', 20);
        $validator->dateTime('created_at');
        if ($forceImage) {
            $validator->requirePresence('image');
        }
        $validator->uploadedFile('image', ['image/jpeg', 'image/png']);

        return $validator->errors($params);
    }
}
