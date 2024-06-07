<?php
namespace App\Controller;

use App\Cores\View;
use App\Cores\Database;
use App\Exception\ValidationException;
use App\Repository\AuthRepository;
use App\Repository\SessionRepository;
use App\Request\UserRequest;
use App\Service\AuthService;
use App\Service\SessionService;

class AuthController
{
    private AuthService $authService;
    private SessionService $sessionService;
    public function __construct()
    {
        $database = Database::getConnection();
        $authRepository = new AuthRepository($database);
        $this->authService = new AuthService($authRepository);

        $sessionRepository = new SessionRepository($database);
        $this->sessionService = new SessionService($authRepository, $sessionRepository);
    }

    public function daftar()
    {
        return View::AuthRender('Auth/Daftar', [
            "title" => "Daftar"
        ]);
    }

    public function login()
    {
        return View::AuthRender('Auth/Login', [
            "title" => "Login"
        ]);
    }

    public function daftarUser()
    {
        $user = new UserRequest();
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        try {
            $this->authService->daftar($user);
            View::redirect("/login");
        } catch (ValidationException $e) {
            View::AuthRender("Auth/Daftar", [
                'title' => 'Daftar',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function loginUser()
    {
        $user = new UserRequest();
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        try {
            $this->authService->login($user);
            View::redirect("/");
        } catch (ValidationException $e) {
            View::AuthRender("Auth/Login", [
                'title' => 'Daftar',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        session_destroy();
        $_SESSION = array();
    }
}