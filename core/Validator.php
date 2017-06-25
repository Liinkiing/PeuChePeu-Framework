<?php

namespace Core;

use DateTime;
use Psr\Http\Message\UploadedFileInterface;

class Validator
{
    private const MIME_TYPES = [
        'jpe'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'png'  => 'image/png',
        'pdf'  => 'application/pdf'
    ];

    /**
     * @var array Stocke les erreurs de validation
     */
    private $errors = [];

    /**
     * @var array
     */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Vérifie si une clef existe dans le tableau.
     *
     * @param string[] ...$keys
     *
     * @return Validator
     */
    public function required(string ...$keys): Validator
    {
        foreach ($keys as $key) {
            if (!isset($this->params[$key]) || empty($this->params[$key])) {
                $this->errors[$key] = 'Le champs est vide';
            }
        }

        return $this;
    }

    /**
     * Vérifie le formatage d'une date.
     *
     * @param $key
     *
     * @return Validator
     */
    public function dateTime($key): Validator
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $this->getValue($key));
        $errors = DateTime::getLastErrors();
        if (!empty($errors['warning_count']) || $dateTime === false) {
            $this->errors[$key] = 'La date ne semble pas valide';
        }

        return $this;
    }

    /**
     * Limite la taille minimale de la chaine.
     *
     * @param $key
     * @param int $length
     *
     * @return Validator
     */
    public function minLength($key, int $length): Validator
    {
        if (mb_strlen($this->getValue($key)) < $length) {
            $this->errors[$key] = "Vous ne pouvez pas écrire moins de $length caractères";
        }

        return $this;
    }

    /**
     * Limite la taille maximale de la chaine.
     *
     * @param $key
     * @param int $length
     *
     * @return Validator
     */
    public function maxLength($key, int $length): Validator
    {
        if (mb_strlen($this->getValue($key)) > $length) {
            $this->errors[$key] = "Vous ne pouvez pas écrire plus de $length caractères";
        }

        return $this;
    }

    /**
     * Limite la chaine pour un slug.
     *
     * @param $key
     *
     * @return Validator
     */
    public function slug($key): Validator
    {
        $pattern = '/^([a-z0-9]+-?)+$/';
        if (!preg_match($pattern, $this->getValue($key))) {
            $this->errors[$key] = 'Le slug ne semble pas valide';
        }

        return $this;
    }

    public function uploaded($key): Validator
    {
        /** @var UploadedFileInterface $file */
        $file = $this->getValue($key);
        if (null === $file || $file->getError() !== UPLOAD_ERR_OK) {
            $this->errors[$key] = 'Vous devez uploader un fichier';
        }

        return $this;
    }

    public function extension($key, array $extensions): Validator
    {
        /** @var UploadedFileInterface $file */
        $file = $this->getValue($key);
        if (null !== $file && $file->getError() === UPLOAD_ERR_OK) {
            $type = $file->getClientMediaType();
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = array_key_exists($extension, static::MIME_TYPES) ? static::MIME_TYPES[$extension] : null;
            if (!in_array($extension, $extensions, true) ||
                $type !== $expectedType
            ) {
                $this->errors[$key] = 'Le fichier ne semble pas valide';
            }
        }

        return $this;
    }

    /**
     * Renvoie la valeur d'un champs.
     *
     * @param $key
     *
     * @return mixed|null
     */
    private function getValue($key)
    {
        if (!array_key_exists($key, $this->params)) {
            return null;
        }

        return $this->params[$key];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
