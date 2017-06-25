<?php

namespace App\Blog;

use Psr\Http\Message\UploadedFileInterface;

class PostUpload
{
    /**
     * Dossier où déplacer les fichiers.
     *
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Gère l'upload d'un fichier pour un article.
     *
     * @param UploadedFileInterface $file
     * @param null|string           $oldImage
     *
     * @return string
     */
    public function upload(UploadedFileInterface $file, ?string $oldImage = null): string
    {
        $this->delete($oldImage);
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
        $file->moveTo($this->getFullPath($file->getClientFilename()));

        return $file->getClientFilename();
    }

    /**
     * Supprime l'image uploadée pour un article.
     *
     * @param null|string $filename
     */
    public function delete(?string $filename): void
    {
        if ($filename) {
            $fullpath = $this->getFullPath($filename);
            if (file_exists($fullpath)) {
                unlink($fullpath);
            }
        }
    }

    private function getFullPath(string $name): string
    {
        return $this->path . '/' . $name;
    }
}
