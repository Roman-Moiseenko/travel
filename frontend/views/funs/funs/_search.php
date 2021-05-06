<?php

use booking\entities\Lang;
use booking\forms\booking\funs\SearchFunForm;
use booking\helpers\funs\FunTypeHelper;
use frontend\widgets\design\BtnFind;use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model SearchFunForm */


?>

<?php $form = ActiveForm::begin([
    'action' => '/' . Lang::current() . '/funs',
    'method' => 'GET'
]) ?>

<div class="row">
    <div class="col">
        <label class="label-search"><?= Lang::t('Дата') ?>:</label>
        <?= DatePicker::widget([
            'id' => 'fun-range',
            'model' => $model,
            'attribute' => 'date_from',
            'attribute2' => 'date_to',
            'type' => DatePicker::TYPE_RANGE,
            'separator' => '-',
            'language' => Lang::current(),
            'pluginOptions' => [
                'startDate' => '+1d',
                'todayHighLight' => true,
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
            ],
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= $form->field($model, 'type')
            ->dropDownList(Lang::a(FunTypeHelper::list()), ['prompt' => '', 'class' => 'change-attr form-control'])
            ->label(Lang::t('Категория') . ':', ['class' => 'label-search']); ?>
    </div>
</div>
<?php foreach ($model->values as $i => $value): ?>
    <div class="row">
        <div class="col">
            <?php $text = '';
            if ($value->isAttributeSafe('from') && $value->isAttributeSafe('to')) {
                $text = '';
            } ?>
            <?= Html::encode($value->getCharacteristicName() . $text) ?>
        </div>
    </div>
    <div class="row">
        <?php if ($variants = $value->variantsList()): ?>
            <div class="col">
                <?= $form->field($value, '[' . $i . ']equal')->dropDownList($variants, ['prompt' => ''])->label(false) ?>
            </div>
        <?php elseif ($value->isAttributeSafe('from') && $value->isAttributeSafe('to')): ?>
            <div class="col-6">
                <?= $form->field($value, '[' . $i . ']from')->textInput(['placeholder' => 'от ' . $value->minValue()])->label(false) ?>
            </div>
            <div class="col-6">
                <?= $form->field($value, '[' . $i . ']to')->textInput(['placeholder' => 'до ' . $value->maxValue()])->label(false) ?>
            </div>
        <?php endif ?>
    </div>
<?php endforeach; ?>
<div class="row">
    <div class="col text-center">
        <?= BtnFind::widget() ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
