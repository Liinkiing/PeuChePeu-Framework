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

    /**
     * Permet de supprimer une clef en session.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function delete(string $key);

    /**
     * Détruit complètement la session.
     *
     * @return mixed
     */
    public function destroy();
}
