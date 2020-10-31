<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourFinanceForm;
use booking\helpers\CalendarHelper;
use booking\helpers\scr;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use Codeception\PHPUnit\ResultPrinter\HTML;
use DateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public $layout = 'main-tours';
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;
    /**
     * @var TourRepository
     */
    private $tours;

    public function __construct(
        $id,
        $module,
        TourService $service,
        TourRepository $tours,
        CostCalendarRepository $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
        $this->tours = $tours;
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
        return $this->render('view', [
            'tour' => $tour,
        ]);
    }

    public function actionUpdate($id)
    {
        $tour = $this->findModel($id);
        $form = new TourFinanceForm($tour);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //scr::p([$form->check_booking, \Yii::$app->request->post()]);
                $this->service->setFinance($tour->id, $form);
                return $this->redirect(['/tour/finance', 'id' => $tour->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'tour' => $tour,
            'model' => $form,
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