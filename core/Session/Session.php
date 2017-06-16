<?php

namespace Core\Session;

class Session implements SessionInterface, \ArrayAccess
{
    private $started = false;
    private $null = null;

    /**
     * Permet de s'assurer que la session est démarrée.
     */
    private function ensureStarted()
    {
        if ($this->started === false && session_status() === PHP_SESSION_NONE) {
            session_start();
            $this->started = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function &get(string $key)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            $result = &$_SESSION[$key];

            return $result;
        }

        $null = &$this->null;

        return $null;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, $value)
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy()
    {
        if ($this->started === true) {
            session_destroy();
            $this->started = false;
        }
    }

    public function offsetExists($offset)
    {
        return $this->get($offset);
    }

    public function &offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }
}
