<?php

use booking\entities\booking\stays\Stay;
use booking\helpers\SysHelper;
/* @var $this yii\web\View */
/* @var  $stay Stay */

$this->title = 'Календарь ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Календарь';




?>
<div class="stay-calendar">
    <input type="hidden" id="number-stay" value="<?= $stay->id ?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <?php if (SysHelper::isMobile()): ?>
                    <div id="datepicker-stay" class="input-group date">
                        <input type="text" class="form-control" id="datepicker_value" readonly>
                        <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                    <!-- ПОВТОР -->
                    <div class="list-stays pt-2"></div>
                    <div class="copy-week-times pt-1"></div>
                <?php else: ?>
                    <table width="100%">
                        <tr>
                            <td width="640px">
                                <div id="datepicker-stay">
                                    <input type="hidden" id="datepicker_value" value="">
                                </div>
                            </td>
                            <td class="p-2" valign="top">
                                <!-- ПОВТОР -->
                                <div class="list-stays pt-2"></div>
                                <div class="copy-week-times pt-1"></div>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>





