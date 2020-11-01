<?php

/* @var $this yii\web\View */

use admin\widgest\chart\ChartJsWidget;
use booking\entities\booking\tours\Tour;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var  $tour Tour*/
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $dataForChart array */
$this->title = 'Отчеты по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Отчеты';


?>
<div class="tour-report">
<div class="card">
    <div class="card-body">
<?=
 ChartJsWidget::widget([
    'type'  => ChartJsWidget::TYPE_LINE,
    'data'  => $dataForChart,
    'options'   => []
])

?>

</div></div>
</div>
