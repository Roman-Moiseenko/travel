<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\admin\ChartForm;
use booking\helpers\scr;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{
    public $layout = 'main-tours';
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
        $form = new ChartForm();
        $tour = $this->findModel($id);
        $form->load(\Yii::$app->request->post());
        $labels = $this->getLabels($form);
        $datasets = [];

        if ($form->views) {
            //TODO получаем $data
            $data =[];
            for ($i = 0; $i < count($labels); $i++) {
                $data[] = rand(600, 900);
            }
            $datasets[] =  $this->getDataset($data, 'blue', 'Просмотрено');
        }

        if ($form->booking) {
            //TODO получаем $data
            $data =[];
            for ($i = 0; $i < count($labels); $i++) {
                $data[] = rand(260, 400);
            }

            $datasets[] =  $this->getDataset($data, 'red', 'Забронировано');
        }
        if ($form->pay) {
            //TODO получаем $data
            $data =[];
            for ($i = 0; $i < count($labels); $i++) {
                $data[] = rand(100, 250);
            }

            $datasets[] =  $this->getDataset($data, 'green', 'Приобретено');
        }

        //TODO Формируем Массив параметров
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
        throw new NotFoundHttpException('The requested page does not exist.');
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