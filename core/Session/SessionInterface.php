<?php

namespace Core\Session;

interface SessionInterface
{
    /**
     * Permet de récupérer une information depuis la session.
     *
     * @param string $key
     */
    public function get(string $key);

    /**
     * Permet de stocker une information en session.
     *
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value);

    public function destroy();
}
