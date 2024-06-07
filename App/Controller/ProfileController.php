<?php
namespace App\Controller;

use App\Cores\View;
use App\Cores\Database;
use App\Model\User;
use App\Service\AuthService;
use App\Repository\AuthRepository;
use App\Exception\ValidationException;

class ProfileController
{
    private AuthService $authService;

    public function __construct()
    {
        $database = Database::getConnection();
        $authRepository = new AuthRepository($database);
        $this->authService = new AuthService($authRepository);
    }

    public function profile()
    {
        $user = $this->authService->current();
        var_dump($user);
        return View::Render("Profile", [
            "title" => "Profile",
            "user" => $user,
        ]);
    }

    public function updateProfile()
    {
        if (empty($_FILES['image']['tmp_name'])) {
            $user = new User();
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->img = null;
            try {
                $this->authService->update($user);
                View::redirect("/profile");
            } catch (ValidationException $e) {
                $user = $this->authService->current();
                View::Render("Profile", [
                    'title' => 'profile',
                    'error' => $e->getMessage(),
                    'user' => $user
                ]);
            }
        } else {
            $imageExtension = ["png", "jpg", "jpeg", "svn"];
            $gambarExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $target = "img/";
            if (!in_array($gambarExtension, $imageExtension)) {
                throw new ValidationException("gambar harus dalam format png, jpg, jpeg, svn");
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                $targerFile = $target . uniqid() . "." . $gambarExtension;
            } else {
                $targerFile = "";
            }
            $user = new User();
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->img = $targerFile;
            try {
                $this->authService->update($user);
                View::redirect("/profile");
            } catch (ValidationException $e) {
                $user = $this->authService->current();
                View::Render("Profile", [
                    'title' => 'profile',
                    'error' => $e->getMessage(),
                    'user' => $user
                ]);
            }
        }
    }
}