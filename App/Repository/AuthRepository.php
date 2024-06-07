<?php
namespace App\Repository;

use App\Model\User;

class AuthRepository
{
    private \PDO $connection;
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findByEmail($email)
    {
        $statement = $this->connection->prepare("select id, name, email, password from users where email = ?");
        $statement->execute([$email]);
        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function daftar(User $user)
    {
        $statement = $this->connection->prepare("insert into users(name, email, password) values(?, ?, ?)");
        $statement->execute([
            $user->name,
            $user->email,
            $user->password,
        ]);
        return $user;
    }

    public function findById($id)
    {
        $statement = $this->connection->prepare("select id, name, email, img, password from users where id = ?");
        $statement->execute([$id]);
        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                if (is_null($row['img'])) {
                    $user->img = null;
                } else {
                    $user->img = $row['img'];
                }
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function updateUser($data)
    {
        if (empty($data['img'])) {
            $statement = $this->connection->prepare("update users set name = ?, email = ? where id = ?");
            $statement->execute([
                $data['name'],
                $data['email'],
                $_SESSION['user_id']
            ]);
        } else {
            $statement = $this->connection->prepare("update users set name = ?, email = ?, img = ? where id = ?");
            $statement->execute([
                $data['name'],
                $data['email'],
                $data['img'],
                $_SESSION['user_id']
            ]);
            move_uploaded_file($_FILES['image']['tmp_name'], $data['img']);
        }
    }
}