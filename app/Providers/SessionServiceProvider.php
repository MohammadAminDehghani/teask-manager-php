<?php

namespace App\Providers;

use App\Core\Session;

class SessionServiceProvider
{
    protected Session $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function boot(): void
    {
        $this->session->start();
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
