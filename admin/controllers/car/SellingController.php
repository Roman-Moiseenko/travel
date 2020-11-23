<?php


namespace admin\controllers\car;


use booking\entities\booking\cars\Car;
use booking\repositories\booking\cars\CostCalendarRepository;
use booking\repositories\booking\cars\SellingCarRepository;
use booking\services\booking\cars\SellingCarService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SellingController extends Controller
{
    public $layout = 'main-cars';
    /**
     * @var SellingCarService
     */
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendars;
    /**
     * @var SellingCarRepository
     */
    private $sellingCars;

    public function __construct(
        $id,
        $module,
        SellingCarService $service,
        CostCalendarRepository $calendars,
        SellingCarRepository $sellingCars,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendars = $calendars;
        $this->sellingCars = $sellingCars;
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
        $car = $this->findModel($id);


        return $this->render('index', [
            'car' => $car
        ]);
    }

    public function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного авто');
            }
            return $model;
        }
        throw new NotFoundHttpException('Авто не найдено ID=' . $id);
    }

    public function actionGetSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $calendar = $this->calendars->getDay($params['car_id'], strtotime($params['date']));
            $sales = $this->sellingCars->getByCalendarId($calendar->id);
            return $this->render('_list_selling', [
                'calendar_id' => $calendar->id,
                'sales' => $sales,
                'error' => '',
            ]);
        }
    }

    public function actionAddSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $error = '';
            if (!$this->service->create($params['calendar_id'], $params['count'])) $error = 'Недостаточно свободных авто';
            $sales = $this->sellingCars->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'calendar_id' => $params['calendar_id'],
                'sales' => $sales,
                'error' => $error,
            ]);
        }
    }

    public function actionRemoveSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $error = '';
            if (!$this->service->remove($params['selling_id'])) $error = 'Ошибка удаление';
            $sales = $this->sellingCars->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'calendar_id' => $params['calendar_id'],
                'sales' => $sales,
                'error' => $error,
            ]);
        }
    }
}