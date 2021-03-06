<?php


/* @var $this yii\web\View */
/* @var  $car Car */

$this->title = 'Календарь ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Календарь';

use booking\entities\booking\cars\Car;
use booking\helpers\SysHelper; ?>
<div class="cars-view">
    <input type="hidden" id="number-car" value="<?= $car->id ?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <?php if (SysHelper::isMobile()): ?>
                    <div id="datepicker-car" class="input-group date">
                        <input type="text" class="form-control" id="datepicker_value" readonly>
                        <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                    <!-- ПОВТОР -->
                    <div class="list-cars pt-2"></div>
                    <div class="copy-week-times pt-1"></div>
                <?php else: ?>
                    <table width="100%">
                        <tr>
                            <td width="640px">
                                <div id="datepicker-car">
                                    <input type="hidden" id="datepicker_value" value="">
                                </div>
                            </td>
                            <td class="p-2" valign="top">
                                <!-- ПОВТОР -->
                                <div class="list-cars pt-2"></div>
                                <div class="copy-week-times pt-1"></div>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>





