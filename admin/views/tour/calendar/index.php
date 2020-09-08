<?php

use booking\entities\booking\tours\Tour;

/* @var $this yii\web\View */
/* @var  $tour Tour */

$this->title = 'Календарь ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Календарь';
?>
<div class="tours-view">
    <input type="hidden" id="number-tour" value="<?=$tour->id?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <div class="col-9">
                    <div id="datepicker">
                        <input type="hidden" id="datepicker_value" value="">
                    </div>
                </div>
                <div class="col-3">
                    <div class="list-tours"></div>
                </div>
            </div>
            <div class="new-tours">
            </div>
        </div>
    </div>
</div>




