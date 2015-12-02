<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Twig_Environment;

class TemplateListener
{
    /** @var Twig_Environment */
    private $twig;

    /** @var  Session */
    private $session;

    public function __construct(Twig_Environment $twig, Session $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $is_app = $event->getRequest()->getUri();
        if (stripos($is_app, "app=true"))
            $this->session->set('app', true);

        if ($this->session->get('app'))
            $this->twig->getLoader()->prependPath(dirname(__DIR__) . '/../../app/Resources/views_mobile');
    }
}