<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
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
        $tour = $this->findModel($id);

        //TODO Определяем тип графика
        // и входные параметры GET

        //TODO Получаем данные в виде массива

        //TODO Формируем Массив параметров

        //TODO передаем в виджет
        $data = [
            'labels' => $this->getLabels(),
            'datasets' => [
                [
                    'data' => [100, 98, 110, 125, 201, 300, 352, 482, 280, 260, 150, 95],
                    'label' =>  'Оплачено',
                    'fill' => false,
                    'lineTension' => 0.1,
                    'backgroundColor' => "rgba(75,192,192,0.4)",
                    'borderColor' => "rgba(75,192,192,1)",
                    'borderCapStyle' => 'butt',
                    'borderDash' => [],
                    'borderDashOffset' => 0.0,
                    'borderJoinStyle' => 'miter',
                    'pointBorderColor' => "rgba(75,192,192,1)",
                    'pointBackgroundColor' => "#fff",
                    'pointBorderWidth' => 1,
                    'pointHoverRadius' => 20,
                    'pointHoverBackgroundColor' => "rgba(75,192,192,1)",
                    'pointHoverBorderColor' => "rgba(220,220,220,1)",
                    'pointHoverBorderWidth' => 2,
                    'pointRadius' => 5,
                    'pointHitRadius' => 10,
                    'spanGaps' => false,
                ],
                [
                    'data' => [120, 148, 170, 225, 221, 309, 389, 501, 301, 305, 200, 250],
                    'label' =>  'Забронировано',
                    'fill' => false,
                    'lineTension' => 0.1,
                    'backgroundColor' => "red",
                    'borderColor' => "red",
                    'borderCapStyle' => 'butt',
                    'borderDash' => [],
                    'borderDashOffset' => 0.0,
                    'borderJoinStyle' => 'miter',
                    'pointBorderColor' => "red",
                    'pointBackgroundColor' => "#fff",
                    'pointBorderWidth' => 1,
                    'pointHoverRadius' => 20,
                    'pointHoverBackgroundColor' => "red",
                    'pointHoverBorderColor' => "rgba(220,220,220,1)",
                    'pointHoverBorderWidth' => 2,
                    'pointRadius' => 5,
                    'pointHitRadius' => 10,
                    'spanGaps' => false,
                ]
            ]
        ];
        return $this->render('index', [
            'tour' => $tour,
            'dataForChart' => $data,
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

    private function getLabels($month = null, $year = null): array
    {
        $result = [];
        if ($month == null) return ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
        if ($month == 12) {
            $end_day = 31;
        } else {
            if ($year == null) $year = (int)date('Y', time());
            $end_day = (int)date('d', (strtotime('01-' . $month . '-' . $year) - 3600 * 24));
        }
        for ($i = 1; $i <= $end_day; $i++) {
            $result[] = $i;
        }
        return $result;
    }

}