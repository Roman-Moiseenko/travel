<?php


namespace admin\controllers\fun;


use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\helpers\BookingHelper;
use booking\repositories\booking\funs\BookingFunRepository;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\services\booking\funs\FunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController extends Controller
{
    public $layout = 'main-funs';
    /**
     * @var FunService
     */
    private $service;
    /**
     * @var BookingFunRepository
     */
    private $bookings;
    /**
     * @var CostCalendarRepository
     */
    private $funs;


    public function __construct($id, $module, FunService $service, BookingFunRepository $bookings, CostCalendarRepository $funs, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->bookings = $bookings;
        $this->funs = $funs;
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
            'fun' => $fun,
            'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
        ]);
    }

    public function actionGetCalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $fun_id = $params['fun_id'];
            $result = $this->funs->getActiveByFun($fun_id);
            return json_encode($result);
        }
    }

    public function actionGetDay()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $fun_id = $params['fun_id'];
            $date = strtotime($params['date']);
            $times = CostCalendar::find()->select('time_at')->andWhere(['fun_id' => $fun_id])->andWhere(['fun_at' => $date])->column();
            $_bookings = [];
            foreach ($times as $time) {
                $bookings = BookingFun::find()->alias('f')
                    ->joinWith('calendars c')
                    ->andWhere(['f.object_id' => $fun_id])
                    ->andWhere(['c.fun_at' => $date])
                    ->andWhere(['c.time_at' => $time]);
                if (!\Yii::$app->user->identity->preferences->view_cancel) {
                    $bookings = $bookings->andWhere(['<>', 'f.status', BookingHelper::BOOKING_STATUS_CANCEL])
                        ->andWhere(['<>', 'f.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
                }
                $bookings = $bookings->all();
                $_bookings[$time] = $bookings;
            }
            //return count($bookings);
            return $this->render('_booking-day', [
                'times' => $_bookings,
                'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
            ]);
        }
    }

    public function actionSetGiveFun()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $booking_number = $params['booking_number'];
            /** @var BookingItemInterface $booking */
            $booking = BookingHelper::getByNumber($booking_number);
            if ($booking && $booking instanceof BookingFun) {
                $booking->setGive();
                $this->bookings->save($booking);
                return '';
            } else {
                \Yii::error('Ошибка! actionSetGiveFun - $booking_number = ' . $booking_number);
                return '<span class="badge badge-danger">error!</span>';
            }
        }
    }


    protected function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного Развлечения');
            }
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая сраница не существует.');
    }
}