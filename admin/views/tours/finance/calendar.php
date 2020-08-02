<?php

use booking\entities\booking\tours\Tours;
use booking\helpers\CalendarHelper;
use dosamigos\datepicker\DatePicker;


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
            <div><input type="checkbox" value="1" checked title="22"> Мультивыбор, при мульти выборе, нельзя просмотреть
                отдельные даты. Установка тура затирает отмеченные даты
            </div>
            <div class="row">
                <?php $data = CalendarHelper::array4Month();?>
                <div id="datepicker">
                    <input type="hidden" id="datepicker_value" value="">
                </div>
            </div>
            <div class="cost-calendar-day"></div>

        </div>
    </div>
</div>




