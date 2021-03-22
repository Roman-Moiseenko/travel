<?php


namespace admin\controllers\stay;


use booking\entities\booking\stays\Stay;
use booking\repositories\booking\stays\ReviewStayRepository;
use booking\services\booking\stays\StayService;
use booking\services\ContactService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReviewController extends Controller
{
    public  $layout = 'main-stays';
    /**
     * @var StayService
     */
    private $service;
    /**
     * @var ReviewStayRepository
     */
    private $reviews;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct($id, $module, StayService $service, ReviewStayRepository $reviews,ContactService $contact, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->reviews = $reviews;
        $this->contact = $contact;
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
        $stay = $this->findModel($id);
        $dataProvider = $this->reviews->getAllByStay($stay->id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'stay' => $stay,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}