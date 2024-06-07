<?php
namespace App\Middleware;

use App\Cores\View;
use App\Cores\Database;
use App\Service\AuthService;
use App\Repository\AuthRepository;

class Guestmiddleware implements Middleware
{
    private AuthService $authService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $authRepository = new AuthRepository($connection);
        $this->authService = new AuthService($authRepository);
    }

    public function before(): void
    {
        $user = $this->authService->current();
        if ($user != null) {
            View::redirect("/");
        }
    }
}