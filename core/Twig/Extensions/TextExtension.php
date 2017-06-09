<?php

namespace Core\Twig\Extensions;

class TextExtension extends \Twig_Extension
{

    public function getFilters()
    {

        return [
            new \Twig_SimpleFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    public function excerpt($content, $maxLength = 100)
    {
        if (strlen($content) > $maxLength) {
            $excerpt = substr($content, 0, $maxLength - 3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt = substr($excerpt, 0, $lastSpace);
            $excerpt .= '...';
        } else {
            $excerpt = $content;
        }

        return $excerpt;
    }

}