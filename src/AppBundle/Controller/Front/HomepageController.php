<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Response;

/**
 * @copyright   Copyright (c) 2017 cleevio.com <hello@cleevio.com>
 * @author      Adam Petroff <adampetroff11235@gmail.com>
 * @package     App
 */
class HomepageController extends Controller
{
    /**
     * @var TwigEngine
     */
    private $twig;

    public function __construct(TwigEngine $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->twig->renderResponse('front/homepage/index.html.twig');
    }
}