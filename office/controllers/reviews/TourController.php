<?php


namespace office\controllers\reviews;


use booking\entities\booking\tours\ReviewTour;
use booking\entities\Rbac;
use office\forms\reviews\ReviewTourSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TourController extends Controller
{

    public function __construct($id, $module, $config = [])
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
        $searchModel = new ReviewTourSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLock($id)
    {
        $review = ReviewTour::findOne($id);
        $review->draft();
        $review->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $review = ReviewTour::findOne($id);
        $review->activate();
        $review->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }
}