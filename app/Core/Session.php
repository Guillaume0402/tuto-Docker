<?php

class Session
{
    private static $started = false;

    public static function start()
    {
        if (!self::$started) {
            session_start();
            self::$started = true;

            // Initialiser le token CSRF si nécessaire
            if (!self::has('_csrf_token')) {
                self::set('_csrf_token', bin2hex(random_bytes(32)));
            }
        }
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        self::start();
        session_destroy();
        $_SESSION = [];
        self::$started = false;
    }

    public static function regenerateId()
    {
        self::start();
        session_regenerate_id(true);

        // Régénérer le token CSRF
        self::set('_csrf_token', bin2hex(random_bytes(32)));
    }

    // Gestion des messages flash
    public static function setFlash($type, $message)
    {
        self::start();
        $_SESSION['_flash'][$type] = $message;
    }

    public static function getFlash($type)
    {
        self::start();

        if (isset($_SESSION['_flash'][$type])) {
            $message = $_SESSION['_flash'][$type];
            unset($_SESSION['_flash'][$type]);
            return $message;
        }

        return null;
    }

    public static function getAllFlash()
    {
        self::start();

        $messages = $_SESSION['_flash'] ?? [];
        $_SESSION['_flash'] = [];

        return $messages;
    }

    public static function hasFlash($type = null)
    {
        self::start();

        if ($type) {
            return isset($_SESSION['_flash'][$type]);
        }

        return !empty($_SESSION['_flash']);
    }

    // Gestion des anciennes données de formulaire
    public static function setOldInput($data)
    {
        self::start();
        $_SESSION['_old_input'] = $data;
    }

    public static function getOldInput($key = null, $default = null)
    {
        self::start();

        if ($key === null) {
            $oldInput = $_SESSION['_old_input'] ?? [];
            $_SESSION['_old_input'] = [];
            return $oldInput;
        }

        $value = $_SESSION['_old_input'][$key] ?? $default;

        if (isset($_SESSION['_old_input'][$key])) {
            unset($_SESSION['_old_input'][$key]);
        }

        return $value;
    }

    public static function hasOldInput($key = null)
    {
        self::start();

        if ($key) {
            return isset($_SESSION['_old_input'][$key]);
        }

        return !empty($_SESSION['_old_input']);
    }

    // Protection CSRF
    public static function getCsrfToken()
    {
        self::start();
        return self::get('_csrf_token');
    }

    public static function verifyCsrfToken($token)
    {
        return hash_equals(self::getCsrfToken(), $token);
    }

    // Utilitaires
    public static function isLoggedIn()
    {
        return self::has('user_id');
    }

    public static function getUserId()
    {
        return self::get('user_id');
    }

    public static function getUsername()
    {
        return self::get('username');
    }

    public static function login($userId, $username)
    {
        self::set('user_id', $userId);
        self::set('username', $username);
        self::regenerateId(); // Sécurité : régénérer l'ID de session
    }

    public static function logout()
    {
        self::remove('user_id');
        self::remove('username');
        self::regenerateId();
    }

    // Gestion des tentatives de connexion
    public static function incrementLoginAttempts($identifier)
    {
        $key = 'login_attempts_' . $identifier;
        $attempts = self::get($key, 0);
        self::set($key, $attempts + 1);
        self::set($key . '_time', time());
    }

    public static function getLoginAttempts($identifier)
    {
        $key = 'login_attempts_' . $identifier;
        $time = self::get($key . '_time', 0);

        // Réinitialiser après 15 minutes
        if (time() - $time > 900) {
            self::remove($key);
            self::remove($key . '_time');
            return 0;
        }

        return self::get($key, 0);
    }

    public static function clearLoginAttempts($identifier)
    {
        $key = 'login_attempts_' . $identifier;
        self::remove($key);
        self::remove($key . '_time');
    }
}
