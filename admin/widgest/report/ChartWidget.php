<?php


namespace admin\widgest\report;


use admin\widgest\report\chart\ChartJSAsset;
use booking\forms\admin\ChartForm;
use booking\helpers\BookingHelper;
use booking\repositories\booking\BookingRepository;
use yii\base\Widget;
use yii\helpers\Json;

class ChartWidget extends Widget
{

    public $object;
    /** @var ChartForm */
    public $form;
    /**
     * @var BookingRepository
     */
    private $bookings;

    public function __construct(BookingRepository $bookings, $config = [])
    {
        parent::__construct($config);
        $this->bookings = $bookings;
    }

    public function run()
    {
        $labels = $this->getLabels($this->form);
        $datasets = [];

        if ($this->form->confirmation) {
            $data = $this->bookings->getforChart($this->object, $this->form->month, $this->form->year, BookingHelper::BOOKING_STATUS_CONFIRMATION);
            $datasets[] =  $this->getDataset($data, 'blue', 'Подтверждено');
        }

        if ($this->form->booking) {
            $data = $this->bookings->getforChart($this->object, $this->form->month, $this->form->year, null);
            $datasets[] =  $this->getDataset($data, '#ffc107 ', 'Забронировано');
        }
        //TODO или подтв. или приобрет
        if ($this->form->pay) {
            $data = $this->bookings->getforChart($this->object, $this->form->month, $this->form->year, BookingHelper::BOOKING_STATUS_PAY);
            $datasets[] =  $this->getDataset($data, '#268fff', 'Приобретено/Подтверждено');
        }

        $listYear = [];
        $begin_year = date('Y', $this->object->public_at ?? time());
        $end_year = date('Y', time());
        for ($i = $begin_year; $i <= $end_year; $i++) {
            $listYear[$i] = $i;
        }
        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        $this->registerScript($data, 'chart_ticket');
        //TODO продано на сумму
        $data2 = $this->bookings->getforChart($this->object, $this->form->month, $this->form->year, BookingHelper::BOOKING_STATUS_PAY);
        $datasets2[] =  $this->getDataset($data2, '#28a745', 'Продано на сумму //СКОРО');
        $data2 = [
            'labels' => $labels,
            'datasets' => $datasets2
        ];
        $this->registerScript($data2, 'chart_money');

        return $this->render('chart', [
            'canvas_id' => 'chart_ticket',
            'canvas_id_money' => 'chart_money',
            'model' => $this->form,
            'listYear' => $listYear,
        ]);
    }

    public function registerScript($data, $canvas_id)
    {
        $dataForChart = Json::encode($data);
        $view = $this->getView();
        ChartJSAsset::register($view);

        $js = <<< JS
            var ctx = $("#$canvas_id");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: $dataForChart,
                options: '[]',
            });
JS;
        $view->registerJs($js);
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
}