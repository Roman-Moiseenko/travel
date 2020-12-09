<?php

use booking\forms\booking\funs\TimesForm;
use yii\bootstrap4\ActiveForm;

/* @var $times array */
/* @var $form ActiveForm */
?>

<?php foreach ($times as $i => $time): ?>
    <?php if (!empty($time['begin'])): ?>
        <div class="row p-1">
            <div class="col-sm-2">
                <b><?= ($i + 1) . ' ' ?></b>
                <input name="TimesForm[<?= $i ?>][begin]" class="form-control" width="100%"
                       value="<?= $time['begin'] ?>"
                       type="time" id="begin-<?= $i ?>" style="display: inline !important; width: auto" readonly>
            </div>
            <div class="col-sm-2">
                <input name="TimesForm[<?= $i ?>][end]" class="form-control" width="100%" value="<?= $time['end'] ?>"
                       type="time" id="end-<?= $i ?>" style="display: inline !important; width: auto" readonly>
                <span class="glyphicon glyphicon-minus remove-time"
                      style="cursor: pointer; display: inline !important; width: auto;" data-i="<?= $i ?>"
                      id="remove-time"></span>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<div class="row">
    <div class="col-sm-2">
        <input name="TimesForm[<?= count($times) ?>][begin]" class="form-control" width="100%" value="" type="time"
               id="begin">
    </div>
    <div class="col-sm-2">
        <input name="TimesForm[<?= count($times) ?>][end]" class="form-control" width="100%" value="" type="time"
               id="end">
    </div>
    <div class="col-sm-1 align-self-center">
        <span class="glyphicon glyphicon-plus add-time" style="cursor: pointer" data-i="<?= count($times) ?>"
              id="add-time"></span>
    </div>
</div>