<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tours;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\helpers\CalendarHelper;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\ToursRepository;
use booking\services\booking\tours\ToursService;
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
     * @var ToursRepository
     */
    private $tours;

    public function __construct(
        $id,
        $module,
        ToursService $service,
        ToursRepository $tours,
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
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        return $this->render('view', [
            'tours' => $tours,
        ]);
    }

    public function actionUpdate($id)
    {
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        $form = new ToursFinanceForm($tours);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setFinance($tours->id, $form);
                return $this->redirect(['/tours/finance', 'id' => $tours->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'tours' => $tours,
            'model' => $form,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tours::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}