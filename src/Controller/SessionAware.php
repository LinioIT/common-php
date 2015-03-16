<?php

namespace Linio\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SessionAware
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param SessionInterface $session
     */
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }
}
