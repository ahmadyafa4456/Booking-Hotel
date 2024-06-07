<?php
namespace App\Service;

use App\Model\Session;
use App\Repository\AuthRepository;
use App\Repository\SessionRepository;

class SessionService
{
    private AuthRepository $authRepository;

    private SessionRepository $sessionRepository;
    public function __construct($authRepository, $sessionRepository)
    {
        $this->authRepository = $authRepository;
        $this->sessionRepository = $sessionRepository;
    }


    public function create($id)
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = $id;
        $this->sessionRepository->save($session);
        return $session;
    }
}