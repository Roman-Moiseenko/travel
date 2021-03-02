<?php

use booking\entities\booking\stays\rules\Rules;
use booking\entities\Lang;
use booking\forms\booking\cars\SearchCarForm;
use booking\forms\booking\stays\SearchStayForm;
use booking\helpers\cars\CarTypeHelper;
use booking\helpers\CityHelper;
use booking\helpers\stays\StayHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model SearchStayForm */

$layout = <<< HTML
<div class="row">
    <div class="col">
        <div class="form-group">
            <label class="mb-0" for="searchstayform-date_from">Дата заезда</label>

            {input1}
  
        </div>
    </div>
</div>
<div class="row">
    <div class="col">   
        <div class="form-group">    
            <label class="mb-0" for="searchstayform-date_to">Дата отъезда</label>
            {input2}
        </div>
    </div>
</div>
HTML;
?>

<?php $form = ActiveForm::begin([
    'action' => '/' . Lang::current() . '/stays',
    'method' => 'GET',
    'enableClientValidation' => false,
]) ?>
<div class="row">
    <div class="col">
        <?= $form->field($model, 'city')
            ->textInput(['class' => 'form-control form-control-xl'])
            ->label('Город' . ':', ['class' => '']); ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="not-flex">
            <?= DatePicker::widget([
                'id' => 'stay-range',
                'model' => $model,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'type' => DatePicker::TYPE_RANGE,
                'layout' => $layout,
                'separator' => '',
                'size' => 'lg',
                'options' => ['class' => 'form-control form-control-xl',],
                'options2' => ['class' => 'form-control form-control-xl',],
                'language' => Lang::current(),
                'pluginOptions' => [
                    'todayHighLight' => true,
                    'autoclose' => true,
                    'format' => 'DD, dd MM yyyy',
                ],
            ]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col form-inline">
        <?= $form->field($model, 'guest')
            ->dropDownList(StayHelper::listGuest(), ['class' => 'change-attr form-control form-control-xl'])
            ->label(false); ?>
        <?= $form->field($model, 'children')
            ->dropDownList(StayHelper::listChildren(), ['class' => 'change-attr form-control form-control-xl ml-1'])
            ->label(false); ?>
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
<div class="row pt-4">
    <div class="col text-center">
        <button class="btn-lg btn-primary" type="submit" style="width: 50%;"><?= Lang::t('Найти') ?></button>
    </div>
</div>

<?php ActiveForm::end(); ?>
