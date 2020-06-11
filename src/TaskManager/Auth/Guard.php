<?php

namespace TaskManager\Auth;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TaskManager\Models\User;

class Guard
{
    protected $session;

    protected $request;

    protected $db;

    /**
     * @var User
     */
    protected $user;

    protected $loggedOut = false;

    public function __construct(SessionInterface $session, Request $request, EntityManager $db)
    {
        $this->session = $session;
        $this->request = $request;
        $this->db = $db;
    }

    public function attempt(string $login, string $password): void
    {
        $userRepository = $this->db->getRepository(User::class);
        $user = $userRepository->findOneBy(['name' => $login]);
        
        if ($user && password_verify($password, $user->getPassword())) {
            $this->login($user);
        }
    }

    public function login(User $user): void
    {
        $this->session->set('auth', $user->getId());
        $this->session->migrate(true);
        $this->setUser($user);
    }

    public function setUser(User $user): Guard
    {
        $this->user = $user;
        $this->loggedOut = false;

        return $this;
    }

    public function user(): ?User
    {
        if ($this->loggedOut) {
            return null;
        }

        if ($this->user !== null) {
            return $this->user;
        }

        $id = $this->session->get('auth');

        if ($id !== null && $this->user = User::find($id)) {
            return $this->user;
        }

        return $this->user;
    }

    public function logout(): void
    {
        $this->session->remove('auth');
        $this->user = null;
        $this->loggedOut = true;
    }
}
