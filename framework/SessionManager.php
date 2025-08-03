<?php

namespace Framework;

class SessionManager {

    public function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function setFlash(string $key, mixed $value): void {
        $this->set('flash_'.$key, $value);
    }

    public function getFlash(string $key, mixed $default = null) {
        $value = $this->get('flash_'.$key, $default);
        
        if ($value !== null) {
            $this->remove('flash_'.$key); // Remove flash data after retrieving it
        }

        return $value;
    }

    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }
}