<?php
/**
 * Created by Adam The Great.
 * Date: 23. 12. 2016
 * Time: 19:34
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Service\ArticleManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class HomepageController extends Controller
{
    /**
     * @var TwigEngine
     */
    private $twig;
    /**
     * @var FormFactory
     */
    private $formFactory;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var ArticleManager
     */
    private $articleManager;

    public function __construct(TwigEngine $twig, FormFactory $formFactory, Session $session, ArticleManager $articleManager)
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->articleManager = $articleManager;
    }

    /**
     * @return Response
     * @Route("/", name="admin_homepage")
     */
    public function indexAction()
    {
        $articles = $this->articleManager->getNonDeletedArticles();


        return $this->twig->renderResponse('admin/homepage/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{article}", name="admin_edit_article")
     */
    public function editArticleAction(Request $request, Article $article)
    {
        $form = $this->formFactory->create(ArticleType::class, $article);
        $form->handleRequest($request);

        $deleteForm = $this->formFactory->createBuilder()
            ->add('delete', SubmitType::class)
            ->getForm();

        $deleteForm->handleRequest($request);
        if ($deleteForm->isSubmitted()) {
            $this->articleManager->deleteArticle($article);
            $this->session->getFlashBag()->add('success', 'Article was deleted successfully');
            return $this->redirectToRoute('admin_homepage');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleManager->saveArticle($form->getData());
            $this->session->getFlashBag()->add('success', 'The item was saved successfully');

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->twig->renderResponse('admin/homepage/edit_article.html.twig', [
            'form_edit' => $form->createView(),
            'form_delete' => $deleteForm->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/new_article", name="admin_new_article")
     * @param Request $request
     * @return Response
     */
    public function newArticleAction(Request $request)
    {
        $form = $this->formFactory->create(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleManager->saveArticle($form->getData());
            $this->session->getFlashBag()->add('success', 'The item was saved successfully');

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->twig->renderResponse('admin/homepage/new_article.html.twig', [
            'form_edit' => $form->createView(),
        ]);
    }
}