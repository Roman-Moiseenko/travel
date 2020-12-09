<?php


namespace office\controllers\reviews;

use booking\entities\booking\funs\ReviewFun;
use booking\entities\Rbac;
use office\forms\reviews\ReviewFunSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FunController extends Controller
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
        $searchModel = new ReviewFunSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLock($id)
    {
        $review = ReviewFun::findOne($id);
        $review->draft();
        $review->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $review = ReviewFun::findOne($id);
        $review->activate();
        $review->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }
}