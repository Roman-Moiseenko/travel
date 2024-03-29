<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\repositories\booking\tours\ReviewTourRepository;
use booking\services\booking\tours\TourService;
use booking\services\ContactService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReviewController extends Controller
{
    public  $layout = 'main-tours';
    /**
     * @var TourService
     */
    private $service;
    /**
     * @var ReviewTourRepository
     */
    private $reviews;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct($id, $module, TourService $service, ReviewTourRepository $reviews,ContactService $contact, $config = [])
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
        $tour = $this->findModel($id);
        $dataProvider = $this->reviews->getAllByTour($tour->id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tour' => $tour,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данной экскурсии');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}