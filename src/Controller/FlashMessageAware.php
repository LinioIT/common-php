<?php

declare(strict_types=1);

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
     * @param string $severity ['success', 'notice', 'warning', 'error']
     * @param string $message
     */
    protected function addFlash($severity, $message)
    {
        $this->session->getFlashBag()->add($severity, $message);
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
