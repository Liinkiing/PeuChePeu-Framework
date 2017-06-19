<?php

namespace App\Admin;

class AdminWidgets
{
    private $widgets = [];

    public function add(AdminWidgetInterface $widget)
    {
        $this->widgets[] = $widget;
    }

    public function getWidgets()
    {
        return $this->widgets;
    }
}
