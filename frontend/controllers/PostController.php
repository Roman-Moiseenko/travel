<?php


namespace frontend\controllers;


use booking\entities\Lang;
use booking\forms\blog\CommentForm;
use booking\repositories\blog\CategoryRepository;
use booking\repositories\blog\PostRepository;
use booking\repositories\blog\TagRepository;
use booking\services\blog\CommentService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    public $layout = 'blog';
    private $posts;
    private $service;
    private $categories;
    private $tags;

    public function __construct(
        $id,
        $module,
        PostRepository $posts,
        CommentService $service,
        CategoryRepository $categories,
        TagRepository $tags,
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
            throw new NotFoundHttpException(Lang::t('Запрашиваемая страница не существует') . '.');
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
            throw new NotFoundHttpException(Lang::t('Запрашиваемая страница не существует') . '.');
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
            throw new NotFoundHttpException(Lang::t('Запрашиваемая страница не существует') . '.');
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
            throw new NotFoundHttpException(Lang::t('Запрашиваемая страница не существует') . '.');
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

    public function actionWidgetMap()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $slug = $params['slug'];
            //получаем все точки из базы
            return json_encode(['точки данных из базы']);
        }
        return $this->goHome();
    }
}