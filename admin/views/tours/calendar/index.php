<?php

use booking\entities\booking\tours\Tours;
use booking\helpers\CalendarHelper;
use dosamigos\datepicker\DatePicker;
use kartik\widgets\TimePicker;


/* @var $this yii\web\View */
/* @var  $tours Tours */

$this->title = 'Календарь ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-view">
    <input type="hidden" id="number-tour" value="<?=$tours->id?>">
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





