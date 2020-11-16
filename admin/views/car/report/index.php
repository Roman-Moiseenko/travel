<?php

/* @var $this yii\web\View */

use admin\widgest\chart\ChartJsWidget;
use booking\entities\booking\cars\Car;
use booking\forms\admin\ChartForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var  $car Car */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $dataForChart array */
/* @var $model ChartForm */

$this->title = 'Отчеты по ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Отчеты';

//Список годов получить для списка
$listYear = [];
$begin_year = date('Y', $car->public_at ?? time());
$end_year = date('Y', $car->public_at ?? time());
for ($i = $begin_year; $i <= $end_year; $i++) {
    $listYear[$i] = $i;
}

?>
<div class="car-report">
    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="row">
        <div class="col-sm-1">
            <?= $form->field($model, 'year')->dropDownList($listYear, ['onchange' => 'submit()'])->label(false) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'month')
                ->radioList([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], [
                    'class' => 'form_radio_group',
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return '<div class="form_radio_group-item">' .
                            Html::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn', 'id' => 'chart-month-' . $value, 'onchange' => 'submit()']) .
                            '<label for="chart-month-' . $value . '">' . ($value == 0 ? 'Все' : $value) . '</label>' .
                            '</div>';
                    },
                ])->label(false)
            ?>
        </div>
        <div class="col-sm-2">
            Всего просмотров: <?=$car->views?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'confirmation')->checkbox(['onchange' => 'submit()'])->label('Подтверждено')?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'booking')->checkbox(['onchange' => 'submit()'])->label('Забронировано')?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'pay')->checkbox(['onchange' => 'submit()'])->label('Приобретено')?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="card">
        <div class="card-body">
            <?=
            ChartJsWidget::widget([
                'type' => ChartJsWidget::TYPE_LINE,
                'data' => $dataForChart,
                'options' => []
            ])
            ?>
        </div>
    </div>
</div>