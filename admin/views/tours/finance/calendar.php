<?php

use booking\entities\admin\user\UserLegal;
use booking\entities\booking\tours\Tours;
use booking\helpers\CalendarHelper;
use booking\helpers\ToursHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tours */
/* @var $multi boolean */

$this->title = 'Календарь ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div><input type="checkbox" value="1" checked title="22"> Мультивыбор, при мульти выборе, нельзя просмотреть отдельные даты. Установка тура затирает отмеченные даты </div>
            <div class="row">
                <?php $data = CalendarHelper::array4Month() ?>
                <?php for ($i = 1; $i < 5; $i ++): ?>
                <div class="col-3">
                    <?= DatePicker::widget([
                        'language' => 'ru',
                        'name' => 'month_' . $i,
                        'type' => DatePicker::TYPE_INLINE,
                        'size' => 'lg',
                        'pluginOptions' => [
                            'startDate' => $data[$i]['start'],
                            'endDate' => $data[$i]['end'],
                            'format' => 'dd-M-yyyy',
                            'multidate' => $multi
                        ],
                        'options' => [
                            'style' => 'display:none'
                        ]
                    ]); ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>




