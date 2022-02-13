<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ArticleType;
use App\Services\Article\Manager\ArticleManager;
use App\Services\FlashMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Message\EmailNotification;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Services\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var ArticleManager
     */
    private $articleManager;

    /**
     * @var TranslatorInterface
     */
    private $trans;


    /**
     * @param Security $security
     */
    public function __construct(Security $security, ArticleManager $articleManager, TranslatorInterface $trans)
    {
        $this->security = $security;
        $this->articleManager = $articleManager;
        $this->trans = $trans;
    }


    /**
     * @Route("/home", name="home", methods={"GET"})
     * @Cache(smaxage="5")
     */
    public function index(Paginator $paginator, ArticleRepository $articleRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        $page = $paginator->getPage();
        $articles = $paginator->getItemList($articleRepository, $page);
        $nbPages = $paginator->countPage($articles);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'nbPages' => $nbPages,
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new/post", name="api_post_new_post", methods={"POST"})
     */
    public function newPost(Request $request, FlashMessage $flashMessage): JsonResponse
    {
        // On récupère les données
        $data = json_decode($request->getContent());

        if(isset($data->title) && !empty($data->title))
        {
            $post = new Article();
            $code = 201;
            // On hydrate l'objet avec les données
            $post->setTitle($data->title);
            $post->setContent($data->content);
            //$image = new Image();
            //$image->setAlt($data->image);
            //$image->setFile($data->image);
            //$post->setImage($image);
            $this->articleManager->create($post);
            $flashMessage->createMessage(
                $request,
                FlashMessage::INFO_MESSAGE,
                $this->trans->trans('backoffice.articles.flashmessage_publish'));

            return new JsonResponse([
                'status' => $code,
                'data' => $post
            ]);
        } else{
            return new JsonResponse('Uncompleted Data', 404);
        }
    }
}
