<?php


namespace admin\controllers\fun;

use booking\entities\booking\funs\Fun;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\repositories\booking\funs\SellingFunRepository;
use booking\services\booking\funs\SellingFunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SellingController extends Controller
{
    public $layout = 'main-funs';
    /**
     * @var SellingFunService
     */
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendars;
    /**
     * @var SellingFunRepository
     */
    private $sellingFuns;

    public function __construct(
        $id,
        $module,
        SellingFunService $service,
        CostCalendarRepository $calendars,
        SellingFunRepository $sellingFuns,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendars = $calendars;
        $this->sellingFuns = $sellingFuns;
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
        $fun = $this->findModel($id);

        return $this->render('index', [
            'fun' => $fun
        ]);
    }

    public function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного развлечения');
            }
            return $model;
        }
        throw new NotFoundHttpException('Развлечение не найдено ID=' . $id);
    }

    public function actionGetTime()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $fun = Fun::findOne($params['fun_id']);
            $calendars = $this->calendars->getDay($params['fun_id'], strtotime($params['date']), false);

            if (Fun::isClearTimes($fun->type_time)) {
                return $calendars[0]->id;
                $sales = $this->sellingFuns->getByCalendarId($calendars[0]->id);
                return $this->render('_list_selling', [
                    'calendar_id' => $calendars[0]->id,
                    'sales' => $sales,
                    'error' => '',
                ]);
            } else {

                return $this->render('_list_times', [
                    'calendars' => $calendars,
                ]);
            }
        }
    }

    public function actionGetSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $sales = $this->sellingFuns->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'calendar_id' => $params['calendar_id'],
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
            if (!$this->service->create($params['calendar_id'], $params['count'])) $error = 'Недостаточно свободных билетов';
            $sales = $this->sellingFuns->getByCalendarId($params['calendar_id']);
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
            $sales = $this->sellingFuns->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'calendar_id' => $params['calendar_id'],
                'sales' => $sales,
                'error' => $error,
            ]);
        }
    }
}