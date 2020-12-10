<?php

use booking\entities\booking\funs\Fun;

/* @var $this yii\web\View */
/* @var  $fun Fun */

$this->title = 'Календарь ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Календарь';

?>
<div class="funs-view">
    <input type="hidden" id="number-fun" value="<?=$fun->id?>">
    <div class="card card-secondary">
        <div class="card-header with-border">Календарь</div>
        <div class="card-body">
            <div class="row">

                <table width="100%">
                    <tr>
                        <td width="640px">
                            <div id="datepicker-fun">
                                <input type="hidden" id="datepicker_value" value="">
                            </div>
                        </td>
                        <td>

                            <div class="set-times"></div>
                            <div class="row">
                                <span class="error-time" style="font-size: larger; font-weight: bold; color: #c12e2a"></span>
                            </div>
                            <div class="button-times pt-1"></div>
                            <div class="copy-week-times pt-1"></div>

                        </td>
                    </tr>
                </table>
            </div>
            <div class="new-fun">
            </div>
        </div>
    </div>
</div>




