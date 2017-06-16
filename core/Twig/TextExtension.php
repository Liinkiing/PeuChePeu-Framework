<?php

namespace Core\Twig;

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
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength - 3);
            $lastSpace = mb_strrpos($excerpt, ' ');
            $excerpt = mb_substr($excerpt, 0, $lastSpace);
            $excerpt .= '...';
        } else {
            $excerpt = $content;
        }

        return $excerpt;
    }
}
