<?php


namespace admin\controllers\stay;

use booking\entities\booking\stays\Stay;
use booking\repositories\booking\stays\SellingStayRepository;
use booking\repositories\booking\stays\CostCalendarRepository;
use booking\services\booking\stays\SellingStayService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SellingController extends Controller
{
    public $layout = 'main-stays';
    /**
     * @var SellingStayService
     */
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendars;
    /**
     * @var SellingStayRepository
     */
    private $sellingStays;

    public function __construct(
        $id,
        $module,
        SellingStayService $service,
        CostCalendarRepository $calendars,
        SellingStayRepository $sellingStays,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendars = $calendars;
        $this->sellingStays = $sellingStays;
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

        return $this->render('index', [
            'stay' => $stay
        ]);
    }

    public function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('Тур не найден ID=' . $id);
    }

    public function actionGetTime()
    {

        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $calendars = $this->calendars->getDay($params['stay_id'], strtotime($params['date']), false);// CostCalendar::find()->andWhere(['tours_id' => $params['tour_id']])->andWhere(['tour_at' => strtotime($params['date'])])->all();
            return $this->render('_list_times', [
                'calendars' => $calendars,
            ]);
        }
    }

    public function actionGetSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            try {
                $error = '';
                $params = \Yii::$app->request->bodyParams;
                $calendar = $this->calendars->getDay($params['stay_id'], strtotime($params['date']), false);
                if ($calendar == null) {
                    $error = 'Нет свободных';

                }
                    $sales = $this->sellingStays->getByCalendarId($calendar->id);


                return $this->render('_list_selling', [
                    'calendar_id' => $calendar ? $calendar->id : null,
                    'sales' => $sales,
                    'error' => $error,
                ]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function actionAddSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $error = '';
            if (!$this->service->create($params['calendar_id'], $params['count'])) $error = 'Недостаточно свободных мест';
            $sales = $this->sellingStays->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'sales' => $sales,
                'error' => $error,
                'calendar_id' => $params['calendar_id'],
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
            $sales = $this->sellingStays->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'sales' => $sales,
                'error' => $error,
                'calendar_id' => $params['calendar_id'],
            ]);
        }
    }
}