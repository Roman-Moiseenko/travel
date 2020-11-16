<?php


/* @var $this yii\web\View */
/* @var  $car Car */

$this->title = 'Календарь ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Календарь';

use booking\entities\booking\cars\Car; ?>
<div class="cars-view">
    <input type="hidden" id="number-car" value="<?=$car->id?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div id="datepicker-car">
                        <input type="hidden" id="datepicker_value" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="list-cars"></div>
                </div>
            </div>

        </div>
    </div>
</div>





