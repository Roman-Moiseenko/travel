<?php

use booking\entities\Lang;
use booking\forms\booking\tours\SearchToursForm;
use booking\helpers\ToursHelper;
use booking\helpers\ToursTypeHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model SearchToursForm */
?>
<div class="row">
<?php $form = ActiveForm::begin([
    //  'action' => 'tours/tours/index',
    'method' => 'GET'
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
                'language' => Lang::current(),
                'pluginOptions' => [
                    'todayHighLight' => true,
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ],
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'type')->dropDownList(Lang::a(ToursTypeHelper::list()), ['prompt' => ''])->label(Lang::t('Категория') . ':', ['class' => 'label-search']); ?>
        </div>
        <div class="col-sm-3">
            <label class="label-search"><?= Lang::t('Цена (от и до)') ?>:</label>
            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'cost_min', ['template' => "{input}"])->textInput(['class' => 'only-numeric form-control'])->label(false); ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'cost_max', ['template' => "{input}"])->textInput(['class' => 'only-numeric form-control'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <label class="label-search"><?= Lang::t('Тип') ?>:</label>
            <div class="form-inline">
            <?= $form->field($model, 'private')->dropDownList(ToursHelper::listPrivate(), ['prompt' => ''])->label(false); ?>
                &#160;<?= Html::submitButton(Lang::t('Найти'), ['class' => 'btn btn-light']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>