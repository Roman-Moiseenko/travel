<?php

use booking\entities\booking\tours\Tour;
use booking\helpers\SysHelper;
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
<h1 style="color: red">Внимание!</h1>
<h2 style="color: red">В данный момент мы меняем данный раздел. Возможны проблемы с отображением полей</h2>

<div class="tours-view">
    <input type="hidden" id="number-tour" value="<?=$tour->id?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?php if (SysHelper::isMobile()):?>
                        <div id="datepicker-tour"  class="input-group date">
                            <input type="text" class="form-control" id="datepicker_value" readonly>
                            <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    <?php else: ?>
                        <div id="datepicker-tour">
                            <input type="hidden" id="datepicker_value" value="">
                        </div>
                    <?php endif; ?>
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





