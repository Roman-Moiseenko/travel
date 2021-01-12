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
use yii\web\Controller;

class ForumController extends Controller
{
    public $layout ='main';
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
        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $posts,
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
        ]);
    }

    public function actionCreatePost($id)
    {
        /** $id - $category_id */
        $category = Category::findOne($id);
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
        ]);


    }

    public function actionUpdatePost($id)
    {

    }

    public function actionRemovePost($id)
    {
        //Проверка на права доступа - модератор
        // если автор, то есть ли сообщения других участников
    }

    public function actionLockPost($id)
    {

    }

    public function actionUnlockPost($id)
    {

    }


    public function actionCreateMessage($id)
    {

    }

    public function actionUpdateMessage($id)
    {

    }

    public function actionRemoveMessage($id)
    {
        //Проверка на права доступа - автор или модератор
    }




}