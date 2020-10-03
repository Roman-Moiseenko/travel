<?php


namespace frontend\controllers;


use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    public $layout = 'blog';
    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var CommentService
     */
    private $service;
    /**
     * @var CategoryReadRepository
     */
    private $categories;
    /**
     * @var TagReadRepository
     */
    private $tags;

    public function __construct(
        $id,
        $module,
        PostReadRepository $posts,
        CommentService $service,
        CategoryReadRepository $categories,
        TagReadRepository $tags,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->posts = $posts;
        $this->service = $service;
        $this->categories = $categories;
        $this->tags = $tags;
    }

    public function actionIndex()
    {
        $dataProvider = $this->posts->getAll();
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    /**
     * @param $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCategory($slug)
    {
        if (!$category = $this->categories->findBySlug($slug)) {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }

        $dataProvider = $this->posts->getAllByCategory($category);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionTag($slug)
    {
        if (!$tag = $this->tags->findBySlug($slug)) {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }

        $dataProvider = $this->posts->getAllByTag($tag);

        return $this->render('tag', [
            'tag' => $tag,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPost($id)
    {
        if (!$post = $this->posts->find($id)) {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }

        return $this->render('post', [
            'post' => $post,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionComment($id)
    {
        if (!$post = $this->posts->find($id)) {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }

        $form = new CommentForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $comment = $this->service->create($post->id, \Yii::$app->user->id, $form);
                return $this->redirect(['post', 'id' => $post->id, '#' => 'comment_' . $comment->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('comment', [
            'post' => $post,
            'model' => $form,
        ]);
    }
}