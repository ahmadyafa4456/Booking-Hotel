<?php
namespace App\Repository;

use App\Model\Session;

class SessionRepository
{
    private \PDO $connection;
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session)
    {
        $statement = $this->connection->prepare("insert into session(id, user_id) values(?, ?)");
        $statement->execute([$session->id, $session->userId]);
        return $session;
    }
}