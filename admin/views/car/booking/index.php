<?php


/* @var $this yii\web\View */
/* @var  $car Car */

$this->title = 'Бронирование ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Бронирование';

use booking\entities\booking\cars\Car; ?>
<div class="cars-view">
    <input type="hidden" id="number-car" value="<?=$car->id?>">
    <div class="card card-secondary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div id="datepicker-booking-car">
                        <input type="hidden" id="datepicker_value" value="">
                    </div>
                    <span class="badge" style="background-color: #dddda1">нет бронирований</span>
                    <span class="badge" style="background-color: #89b7ca">имеются бронирования</span>
                    <span class="badge" style="background-color: #b3dfb1">100% бронирование</span>
                    <i style="color: red">*</i> - <span class="badge">день выдачи транспорта</span>
                </div>
                <div class="col-md-3">
                    <div class="booking-day"></div>
                </div>
            </div>
        </div>
    </div>
</div>





