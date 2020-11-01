<?php

/* @var $this yii\web\View */

use admin\widgest\chart\ChartJsWidget;
use booking\entities\booking\tours\Tour;
use booking\forms\admin\ChartForm;
use booking\helpers\BookingHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var  $tour Tour */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $dataForChart array */
/* @var $model ChartForm */
$this->title = 'Отчеты по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Отчеты';

$begin_year = date('Y', $tour->public_at ?? time());
$end_year = date('Y', $tour->public_at ?? time());
?>
<div class="tour-report">
    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="row">
        <div class="col-1">
            <?= $form->field($model, 'year')->dropDownList([2020], ['onchange' => 'submit()'])->label(false) ?>
        </div>
        <div class="col-6">
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
