<?php

use booking\entities\Lang;
use booking\forms\booking\trips\SearchTripForm;
use booking\helpers\SysHelper;
use booking\helpers\trips\TripTypeHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;


/* @var $model SearchTripForm */
?>
<div class="row">
    <?php $form = ActiveForm::begin([
        'method' => 'GET',
        'action' => '/trips',
    ]) ?>
    <div class="topbar-search-tours">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <label class="label-search"><?= Lang::t('Дата') ?>:</label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'bsVersion' =>  '4.x',
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
            <div class="col-lg-3 col-sm-6">
                <?= $form->field($model, 'type_id')->dropDownList(Lang::a(TripTypeHelper::list()), ['prompt' => ''])->label(Lang::t('Категория') . ':', ['class' => 'label-search']); ?>
            </div>
            <div class="col-lg-3 col-sm-6">
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
            <div class="col col-lg-3 col-sm-6">
                <label class="label-search"><?= Lang::t('Тип') ?>:</label>
                <div class="form-inline">
                    <?php if (SysHelper::isMobile()): ?>
                        <div class="d2-btn-box" style="margin-top: -12px">
                            <button type="submit" class="d2-btn d2-btn d2-btn-block d2-btn-sm d2-btn-main" title="<?= Lang::t('Найти') ?>">
                                <div class="d2-btn-caption"><?= Lang::t('Найти')?></div>
                                <div class="d2-btn-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                            </button>
                        </div>
                    <?php else: ?>
                    <div class="ml-1 d2-btn-box">
                        <button type="submit" class="d2-btn d2-btn d2-btn-sm d2-btn-main" title="<?= Lang::t('Найти') ?>">
                            <div class="d2-btn-icon">
                                <i class="fas fa-search"></i>
                            </div>
                        </button>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>