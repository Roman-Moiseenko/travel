<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\admin\ChartForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{
    public $layout = 'main-tours';
    /**
     * @var BookingTourRepository
     */
    private $bookings;

    public function __construct($id, $module, BookingTourRepository $bookings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookings = $bookings;
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
        $form = new ChartForm();
        $tour = $this->findModel($id);
        $form->load(\Yii::$app->request->post());
        $labels = $this->getLabels($form);
        $datasets = [];

        if ($form->confirmation) {
            $data = $this->bookings->getforChart($tour->id, $form->month, $form->year, BookingHelper::BOOKING_CONFIRMATION);
            $datasets[] =  $this->getDataset($data, 'blue', 'Подтверждено');
        }

        if ($form->booking) {
            $data = $this->bookings->getforChart($tour->id, $form->month, $form->year, null);
            $datasets[] =  $this->getDataset($data, 'red', 'Забронировано');
        }
        if ($form->pay) {
            $data = $this->bookings->getforChart($tour->id, $form->month, $form->year, BookingHelper::BOOKING_STATUS_PAY);
            $datasets[] =  $this->getDataset($data, 'green', 'Приобретено');
        }

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];

        return $this->render('index', [
            'tour' => $tour,
            'dataForChart' => $data,
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
        throw new NotFoundHttpException('Тур не найден ID=' . $id);
    }

    private function getLabels(ChartForm $form): array
    {
        $result = [];
        if ($form->month == 0) return ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
        $end_day = (int)date('t', strtotime('01-' . $form->month . '-' . $form->year));
        for ($i = 1; $i <= $end_day; $i++) {
            $result[] = $i;
        }
        return $result;
    }

    private function getDataset(array $data, string $color, string $label): array
    {
        return  [
            'data' => $data,
            'label' => $label,
            'fill' => false,
            'lineTension' => 0.1,
            'backgroundColor' => $color,
            'borderColor' => $color,
            'borderCapStyle' => 'butt',
            'borderDash' => [],
            'borderDashOffset' => 0.0,
            'borderJoinStyle' => 'miter',
            'pointBorderColor' => $color,
            'pointBackgroundColor' => "#fff",
            'pointBorderWidth' => 1,
            'pointHoverRadius' => 15,
            'pointHoverBackgroundColor' => $color,
            'pointHoverBorderColor' => "rgba(220,220,220,1)",
            'pointHoverBorderWidth' => 2,
            'pointRadius' => 5,
            'pointHitRadius' => 10,
            'spanGaps' => false,
        ];
    }

}