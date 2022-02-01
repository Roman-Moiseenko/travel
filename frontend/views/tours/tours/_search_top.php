<?php

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\SysHelper;
use booking\helpers\tours\TourHelper;
use booking\helpers\tours\TourTypeHelper;
use frontend\widgets\design\BtnFind;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model SearchTourForm */
?>
<div class="row">
    <?php $form = ActiveForm::begin([
        'method' => 'GET',
        'action' => '/tours',
    ]) ?>
    <div class="topbar-search-tours">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <?= $form->field($model, 'type')->dropDownList(Lang::a(TourTypeHelper::list()), ['prompt' => ''])->label(Lang::t('Категория') . ':', ['class' => 'label-search']); ?>
            </div>
            <div class="col-lg-4 col-sm-6">
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
            <div class="col col-lg-4 col-sm-6">
                <label class="label-search"><?= Lang::t('Тип') ?>:</label>
                <div class="form-inline">
                    <?= $form->field($model, 'private')->dropDownList(TourHelper::listPrivate(), ['prompt' => ''])->label(false); ?>
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