<?php


namespace frontend\controllers\cabinet;


use booking\repositories\ReviewRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class ReviewController extends Controller
{
    public $layout = 'cabinet';
    /**
     * @var ReviewRepository
     */
    private $reviews;

    public function __construct($id, $module, ReviewRepository $reviews, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->reviews = $reviews;
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
        $reviews = $this->reviews->getByUser(\Yii::$app->user->id);

        $this->render('index', [
            'reviews' => $reviews,
        ]);
    }

}