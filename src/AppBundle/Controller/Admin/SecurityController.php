<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Admin;
use AppBundle\Form\AdminAccountType;
use AppBundle\Form\AdminForgottenPassword;
use AppBundle\Form\AdminLoginType;
use AppBundle\Form\NewAdminType;
use AppBundle\Service\AdminManager;
use AppBundle\Utils\SecurityUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @var AdminManager
     */
    private $adminManager;
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;
    /**
     * @var TwigEngine
     */
    private $twig;
    /**
     * @var FormFactory
     */
    private $formFactory;
    /**
     * @var SecurityUtils
     */
    private $securityUtils;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Router
     */
    private $router;

    public function __construct(
        TwigEngine $twig,
        AdminManager $adminManager,
        AuthenticationUtils $utils,
        FormFactory $formFactory,
        SecurityUtils $securityUtils,
        Session $session,
        Router $router
    ) {
        $this->adminManager = $adminManager;
        $this->authenticationUtils = $utils;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->securityUtils = $securityUtils;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->securityUtils->getLastAdminUsername();
        $loginForm = $this->formFactory->create(AdminLoginType::class, ['_username' => $lastUsername]);
        $fromLogout = $request->query->get('from_logout');

        if ($fromLogout) {
            $this->session->getFlashBag()->add('notice', 'You have been logged out successfully');
        }

        return $this->twig->renderResponse('admin/security/login.html.twig', [
            'error' => $error,
            'loginform' => $loginForm->createView()
        ]);
    }
}