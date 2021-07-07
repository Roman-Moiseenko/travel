<?php

use booking\entities\booking\trips\Trip;
use booking\helpers\SysHelper;
use yii\web\View;

/* @var $this View */
/* @var $trip Trip|null */
$this->title = 'Календарь ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Календарь';

?>

<div class="trip-view">
    <input type="hidden" id="number-trip" value="<?= $trip->id ?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <?php if (SysHelper::isMobile()): ?>
                <div id="datepicker-trip" class="input-group date">
                    <input type="text" class="form-control" id="datepicker_value" readonly>
                    <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                </div>
                <!-- ПОВТОР -->
                <div class="list-trip pt-2"></div>
                <div class="copy-week-times pt-1"></div>
                <div class="new-trip pt-1">
                    <?php else: ?>
                        <table width="100%">
                            <tr>
                                <td width="640px">
                                    <div id="datepicker-trip">
                                        <input type="hidden" id="datepicker_value" value="">
                                    </div>
                                </td>
                                <td class="p-2" valign="top">
                                    <!-- ПОВТОР -->
                                    <div class="list-trips"></div>
                                    <div class="copy-week-times pt-1"></div>
                                    <div class="new-trip pt-1">
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>





