<?php


namespace admin\controllers;


use booking\entities\admin\User;
use booking\entities\forum\Category;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use booking\forms\forum\MessageForm;
use booking\forms\forum\PostForm;
use booking\repositories\forum\PostRepository;
use booking\services\forum\CategoryService;
use booking\services\forum\PostService;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class ForumController extends Controller
{
    public $layout = 'main';
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var PostService
     */
    private $postService;
    /**
     * @var PostRepository
     */
    private $posts;

    public function __construct(
        $id,
        $module,
        CategoryService $categoryService,
        PostService $postService,
        PostRepository $posts,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->categoryService = $categoryService;
        $this->postService = $postService;
        $this->posts = $posts;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        //получаем все категории, отображаем по сортировке
        $categories = Category::find()->orderBy(['sort' => SORT_ASC])->all();
        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionCategory($id)
    {
        $category = Category::findOne($id);
        $posts = $this->posts->getAll($category->id);
        $user = User::findOne(\Yii::$app->user->id);
        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $posts,
            'user' => $user,
        ]);
    }

    public function actionPost($id)
    {
        $post = Post::findOne($id);
        $messages = $this->posts->getMessages($post->id);
        /**** ПЕРЕДЕЛАТЬ  !!!!!!! **/
        $user = User::findOne(\Yii::$app->user->id);
        $user->readForum($id);
        $user->save();
        /** **************** **/
        $form = new MessageForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->postService->addMessage($post->id, $form);
                return $this->redirect(['forum/post', 'id' => $post->id]);
                //TODO Переход на последнюю страницу
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('post', [
            'post' => $post,
            'dataProvider' => $messages,
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionCreatePost($id)
    {
        /** $id - $category_id */
        $category = Category::findOne($id);
        $user = User::findOne(\Yii::$app->user->id);
        $form = new PostForm($category->id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->postService->create($form);
                return $this->redirect(['forum/post', 'id' => $post->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('post-create', [
            'category' => $category,
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionRemovePost($id)
    {
        try {
            $this->postService->removePost($id);
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
        //Проверка на права доступа - модератор
        // если автор, то есть ли сообщения других участников
    }

    public function actionFixPost($id)
    {
        try {
            $this->postService->fix($id);
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionUnfixPost($id)
    {
        try {
            $this->postService->unFix($id);
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionLockPost($id)
    {
        try {
            $this->postService->lock($id);
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionUnlockPost($id)
    {
        try {
            $this->postService->unLock($id);
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }


    public function actionUpdateMessage($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        $message = Message::findOne($id);
        $form = new MessageForm($message);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->postService->editMessage($message->post_id, $message->id, $form);
                return $this->redirect(['forum/post', 'id' => $message->post_id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('post-update', [
            'post' => $message->post,
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionRemoveMessage($id)
    {
        $message = Message::findOne($id);
        $post = $message->post;
        try {
            if ($post->count == 1) {
                $this->postService->removePost($post->id);
                return $this->redirect(Url::to(['forum/category', 'id' => $post->category_id]));
            } else {
                $this->postService->removeMessage($post->id, $id);
                return $this->redirect(\Yii::$app->request->referrer);
            }
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

}