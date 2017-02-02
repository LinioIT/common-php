<?php

namespace Linio\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait TemplatingAware
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * Returns a rendered view.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return string The rendered view
     */
    public function renderView($view, array $parameters = [])
    {
        return $this->templating->render($view, $parameters);
    }

    /**
     * Renders a view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = [], Response $response = null)
    {
        return $this->templating->renderResponse($view, $parameters, $response);
    }

    /**
     * Streams a view.
     *
     * @param string           $view       The view name
     * @param array            $parameters An array of parameters to pass to the view
     * @param StreamedResponse $response   A response instance
     *
     * @return StreamedResponse A StreamedResponse instance
     */
    public function stream($view, array $parameters = [], StreamedResponse $response = null)
    {
        $templating = $this->templating;

        $callback = function () use ($templating, $view, $parameters) {
            $templating->stream($view, $parameters);
        };

        if (null === $response) {
            return new StreamedResponse($callback);
        }

        $response->setCallback($callback);

        return $response;
    }
}
