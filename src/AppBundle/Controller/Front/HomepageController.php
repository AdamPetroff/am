<?php

namespace AppBundle\Controller\Front;

use AppBundle\Service\ArticleManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    /**
     * @var ArticleManager
     */
    private $articleManager;

    public function __construct(TwigEngine $twig, ArticleManager $articleManager)
    {
        $this->twig = $twig;
        $this->articleManager = $articleManager;
    }

    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->twig->renderResponse('front/homepage/index.html.twig');
    }

    /**
     * @Route("/{articleUrl}", name="article")
     */
    public function articleAction($articleUrl)
    {
        if($article = $this->articleManager->getArticleByUrl($articleUrl)) {
            return $this->twig->renderResponse('front/homepage/article.html.twig', ['article' => $article]);
        } else {
            throw new NotFoundHttpException();
        }
    }
}