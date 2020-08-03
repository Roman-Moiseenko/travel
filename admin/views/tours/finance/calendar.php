<?php

use booking\entities\booking\tours\Tours;
use booking\helpers\CalendarHelper;
use dosamigos\datepicker\DatePicker;
use kartik\widgets\TimePicker;


/* @var $this yii\web\View */
/* @var  $tours Tours */
/* @var $multi boolean */

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
            <div class="new-tours hidden">
                <div id="data-day" data-d="$D" data-m="$M" data-y="$Y"></div>
                <div class="row">

                    <div class="col-2">
                        <div class="form-group">
                            <label>Начало</label>
                            <input class="form-control" name="_time" type="time" width="100px" value="00:00" required>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label>Билеты</label>
                            <input class="form-control" name="_tickets" type="number" width="100px" required>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за взрослый</label>
                            <input class="form-control" name="_adult" type="number" width="100px" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за детский</label>
                            <input class="form-control" name="_child" type="number" width="100px">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за льготный</label>
                            <input class="form-control" name="_preference" type="number" width="100px">
                        </div>
                    </div>
                    <div class="col-1">
                        <a href="#" class="btn btn-success" id="send-new-tour">Добавить</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





