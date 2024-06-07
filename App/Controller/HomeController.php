<?php
namespace App\Controller;

use App\Cores\View;

class HomeController
{
    public function home()
    {
        return View::Render("Home", [
            'title' => 'Home',
        ]);
    }
}