<?php


namespace app\core;


class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_save_path('C:\Program Files\XAMPP\htdocs\php_mvc_framework');
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // &$flashMessage is passed by reference so it's modified and not its copy
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['read'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'message' => $message, 'read' => false
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['message'] ?? 0;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // &$flashMessage is passed by reference so it's modified and not its copy
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['read']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}