<?php

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\tours\TourHelper;
use booking\helpers\tours\TourTypeHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model SearchTourForm */
?>

<?php $form = ActiveForm::begin([
      //  'action' => 'tours/tours/index',
]) ?>
<div class="topbar-search-tours">
    <div class="row">
        <div class="col-sm-3">
            <label class="label-search"><?= Lang::t('Дата') ?>:</label>
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'type' => DatePicker::TYPE_RANGE,
                'separator' => '-',
                'language' => 'ru',
                'pluginOptions' => [
                    'todayHighLight' => true,
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ],
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'type')->dropDownList(TourTypeHelper::list(), ['prompt' => ''])->label('Категория:', ['class' => 'label-search']); ?>
        </div>
        <div class="col-sm-3">
            <label class="label-search">Цена (от и до):</label>
            <div class="input-group input-daterange">
                <?= $form->field($model, 'cost_min', ['template' => "{input}"])->textInput(['class' => 'only-numeric form-control'])->label(false); ?>
                <span class="input-group-addon" >-</span>
                <?= $form->field($model, 'cost_max',  ['template' => "{input}"])->textInput(['class' => 'only-numeric form-control'])->label(false) ?>
            </div>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'private')->dropDownList(TourHelper::listPrivate(), ['prompt' => ''])->label('Тип:', ['class' => 'label-search']); ?>
        </div>
        <div class="col-sm-1">
            <label class="label-search"> </label>
            <?= Html::submitButton(Lang::t('Найти') . ' <i class="fas fa-search"></i>', ['class' => 'btn btn-primary', 'style' => 'border: 0 !important;']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
