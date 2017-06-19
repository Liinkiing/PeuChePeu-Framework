<?php

namespace App\Admin;

/**
 * Interface permettant de définir comment doit être rendu le widget.
 */
interface AdminWidgetInterface
{
    public function render(): string;
}
