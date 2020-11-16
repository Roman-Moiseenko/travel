<?php


namespace office\controllers\reviews;

use booking\entities\booking\cars\ReviewCar;
use booking\entities\Rbac;
use booking\repositories\booking\cars\ReviewCarRepository;
use office\forms\reviews\ReviewCarSearch;
use office\forms\reviews\ReviewTourSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CarController extends Controller
{

    public function __construct($id, $module, ReviewCarRepository $reviews, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ReviewCarSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLock($id)
    {
        $review = ReviewCar::findOne($id);
        $review->draft();
        $review->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $review = ReviewCar::findOne($id);
        $review->activate();
        $review->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }
}