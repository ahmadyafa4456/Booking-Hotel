<?php
namespace App\Cores;

class View
{
    public static function Render(string $view, $data)
    {
        require_once __DIR__ . '/../View/Layout/Header.php';
        require_once __DIR__ . '/../View/' . $view . '.php';
        require_once __DIR__ . '/../View/Layout/Footer.php';
    }
    public static function AuthRender(string $view, $data)
    {
        require_once __DIR__ . '/../View/' . $view . '.php';
    }

    public static function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}