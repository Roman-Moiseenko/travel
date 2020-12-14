<?php


namespace admin\controllers;


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

    public function __construct(
        $id,
        $module,
        CategoryService $categoryService,
        PostService $postService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->categoryService = $categoryService;
        $this->postService = $postService;
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

    }

    public function actionCategory($id)
    {

    }

    public function actionPost($id)
    {

    }

    public function actionCreateCategory()
    {

    }

    public function actionUpdateCategory($id)
    {

    }

    public function actionCreatePost($id)
    {

    }

    public function actionUpdatePost($id)
    {

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

    }




}