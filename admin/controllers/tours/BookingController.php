<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tour;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController  extends Controller
{
    public  $layout = 'main-tours';
    /**
     * @var TourService
     */
    private $service;

    public function __construct($id, $module, TourService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    public function actionIndex($id)
    {
        $tours = $this->findModel($id);
        return $this->render('index', [
            'tours' => $tours
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}