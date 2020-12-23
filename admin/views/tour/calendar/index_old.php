<?php

use booking\entities\booking\tours\Tour;
use Codeception\PHPUnit\ResultPrinter\HTML;
use yii\helpers\Url;


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
                <div class="col-md-9">
                    <div id="datepicker-tour"  class="input-group date">
                        <input type="text" class="form-control" id="datepicker_value"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="list-tours"></div>
                </div>
            </div>
            <div class="new-tours">
            </div>
        </div>
    </div>
</div>






