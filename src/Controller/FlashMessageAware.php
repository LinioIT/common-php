<?php

namespace Linio\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

trait FlashMessageAware
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * Adds a flash message to the current session for type.
     *
     * @param string $type    The type
     * @param string $message The message
     *
     * @return void
     */
    protected function addFlash($type, $message)
    {
        $this->session->getFlashBag()->add($type, $message);
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }
}
