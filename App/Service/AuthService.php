<?php
namespace App\Service;

use App\Model\User;
use App\Repository\AuthRepository;
use App\Exception\ValidationException;

class AuthService
{
    private AuthRepository $authRepository;
    public function __construct($authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function validatedInput($request)
    {
        if (is_object($request)) {
            $request = (array) $request;
        }
        if (is_array($request)) {
            $data = [];
            foreach ($request as $key => $value) {
                $value = trim($value);
                $value = strip_tags($value);
                $value = stripcslashes($value);
                $value = htmlspecialchars($value);
                $data[$key] = $value;
            }
            return $data;
        } else {
            return null;
        }
    }

    public function Validated($data)
    {
        $data = $this->validatedInput($data);

        if (!isset($data['name']) || $data['name'] === null || $data['name'] === '') {
            throw new ValidationException("nama tidak boleh kosong");
        }

        if (strlen($data['name']) < 4) {
            throw new ValidationException("name harus lebih dari 4 karakter");
        }

        if (!isset($data['email']) || $data['email'] === null || $data['email'] === '') {
            throw new ValidationException("email tidak boleh kosong");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("email harus valid");
        }

        if (!isset($data['password']) || $data['password'] === null || $data['password'] === '') {
            throw new ValidationException("password tidak boleh kosong");
        }

        if (strlen($data['password']) < 4) {
            throw new ValidationException("password harus lebih dari 4 karakter");
        }

        return $data;
    }


    public function daftar($user)
    {
        $data = $this->Validated($user);
        $user = $this->authRepository->findByEmail($data['email']);
        if ($user != null) {
            throw new ValidationException("Email sudah terdaftar");
        }
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->authRepository->daftar($user);
    }

    public function login($user)
    {
        $data = $this->Validated($user);
        $user = $this->authRepository->findByEmail($data['email']);
        if ($user == null) {
            throw new ValidationException("Email atau Password Salah");
        }
        if (password_verify($data['password'], $user->password)) {
            $_SESSION['user_id'] = $user->id;
            return $user;
        } else {
            throw new ValidationException("Email atau Password Salah");
        }
    }

    public function current()
    {
        if (isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            return $this->authRepository->findById($id);
        } else {
            return null;
        }
    }

    public function update($user)
    {
        $data = $this->Validated($user);
        $oldImage = $this->current();
        if (!empty($data['img'])) {
            if (file_exists($oldImage->img)) {
                unlink($oldImage->img);
            }
        }
        $this->authRepository->updateUser($data);
    }
}