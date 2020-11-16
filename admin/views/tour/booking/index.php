<?php


/* @var $this yii\web\View */
/* @var  $tour Tour */

$this->title = 'Бронирование ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Бронирование';


use booking\entities\booking\tours\Tour; ?>
<div class="tours-view">
    <input type="hidden" id="number-tour" value="<?=$tour->id?>">
    <div class="card card-secondary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div id="datepicker-booking-tour">
                        <input type="hidden" id="datepicker_value" value="">
                    </div>
                    <span class="badge" style="background-color: #dddda1">нет бронирований</span>
                    <span class="badge" style="background-color: #89b7ca">имеются бронирования</span>
                    <span class="badge" style="background-color: #b3dfb1">100% бронирование</span>
                </div>
                <div class="col-md-3">
                    <div class="booking-day"></div>
                </div>
            </div>
        </div>
    </div>
</div>





