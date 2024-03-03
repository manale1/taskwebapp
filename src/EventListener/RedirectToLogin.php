<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class RedirectToLogin
{
    private $security;
    private $router;

    public function __construct(Security $security, RouterInterface $router)
    {
        $this->security = $security;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // Vérifier si l'utilisateur n'est pas connecté et si la route actuelle n'est pas déjà la page de connexion ou la page de la modification de mot de passe
        if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY') && $request->attributes->get('_route') !== 'app_login' && $request->attributes->get('_route') !== 'app_forgot_password_request'
            && $request->attributes->get('_route') !== 'app_check_email' && $request->attributes->get('_route') !== 'app_reset_password') {

                $url = $this->router->generate('app_login');
                $event->setResponse(new RedirectResponse($url));

        }
    }
}