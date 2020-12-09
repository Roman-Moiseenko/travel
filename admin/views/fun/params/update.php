<?php

use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\FunParamsForm;

use booking\helpers\funs\WorkModeHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model FunParamsForm */
/* @var $fun Fun */

$this->title = 'Редактировать Развлечение ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['/fun/params', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="fun-params">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="card card-secondary">
        <div class="card-header with-border">Основные параметры</div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'annotation')->textarea()->label('Аннотация к комментарию заказа')->hint('Оставьте пустым, если не требуется') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->ageLimit, 'on')->checkbox()->label('Ограничение по возрасту') ?>
                </div>
                <div class="col-md-3 agelimit-edit"
                     id="agelimitmin" <?= $model->ageLimit->on ? '' : 'style="display: none;"' ?>>
                    <?= $form->field($model->ageLimit, 'ageMin')->textInput(['maxlength' => true])->label('Минимальный возраст') ?>
                </div>
                <div class="col-md-3 agelimit-edit" <?= $model->ageLimit->on ? '' : 'style="display: none;"' ?>>
                    <?= $form->field($model->ageLimit, 'ageMax')->textInput(['maxlength' => true])->label('Максимальный возраст') ?>
                </div>
            </div>

        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Характеристики</div>
        <div class="card-body">
            <?php foreach ($model->values as $i => $value): ?>
                <?php if ($variants = $value->variantsList()): ?>
                    <?= $form->field($value, '[' . $i . ']value')->dropDownList($variants, ['prompt' => '']) ?>
                <?php else: ?>
                    <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Режим работы</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-1">
                </div>
                <div class="col-sm-2">
                    <b>Режим дня</b>
                </div>
                <div class="col-sm-2">
                    <b>Обед</b>
                </div>
            </div>
            <?php foreach ($model->workModes as $i => $mode): ?>
            <div class="row">
                <div class="col-sm-1">
                    <?= WorkModeHelper::week($i)?>
                </div>
                <div class="col-sm-1">
                <?= $form->field($mode, '[' . $i . ']day_begin')->textInput(['type' => 'time'])->label(false) ?>
                </div>
                <div class="col-sm-1">
                <?= $form->field($mode, '[' . $i . ']day_end')->textInput(['type' => 'time'])->label(false) ?>
                </div>
                <div class="col-sm-1">
                <?= $form->field($mode, '[' . $i . ']break_begin')->textInput(['type' => 'time'])->label(false) ?>
                </div>
                <div class="col-sm-1">
                <?= $form->field($mode, '[' . $i . ']break_end')->textInput(['type' => 'time'])->label(false) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

