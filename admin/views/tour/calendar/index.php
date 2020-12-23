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
<div class="tours-view">
    <input type="hidden" id="number-tour" value="<?= $tour->id ?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">
                <?php if (SysHelper::isMobile()): ?>
                <div id="datepicker-tour" class="input-group date">
                    <input type="text" class="form-control" id="datepicker_value" readonly>
                    <span class="input-group-addon form-control-sm"><i class="glyphicon glyphicon-th"></i></span>
                </div>
                <!-- ПОВТОР -->
                <div class="list-tours"></div>
                <div class="copy-week-times pt-1"></div>
                <div class="new-tours pt-1">
                    <?php else: ?>
                        <table width="100%">
                            <tr>
                                <td width="640px">
                                    <div id="datepicker-tour">
                                        <input type="hidden" id="datepicker_value" value="">
                                    </div>
                                </td>
                                <td class="p-2" valign="top">
                                    <!-- ПОВТОР -->
                                    <div class="list-tours pt-1"></div>
                                    <div class="copy-week-times pt-1"></div>
                                    <div class="new-tours pt-1">
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>





