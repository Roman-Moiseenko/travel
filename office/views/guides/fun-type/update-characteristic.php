<?php

use booking\entities\booking\funs\Characteristic;
use booking\forms\booking\funs\CharacteristicForm;
use booking\helpers\funs\CharacteristicHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CharacteristicForm */
/* @var $characteristic Characteristic */

$this->title = 'Изменить Характеристику ' . $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории Развлечений', 'url' => Url::to(['guides/fun-type/index'])];
$this->params['breadcrumbs'][] = ['label' => $characteristic->type->name, 'url' => Url::to(['guides/fun-type/view', 'id' => $characteristic->type_fun_id])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="characteristic-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Имя') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'type_variable')->dropDownList(CharacteristicHelper::typeList())->label('Тип') ?>
                </div>
                <div class="col">

            <?= $form->field($model, 'sort')->textInput(['maxlength' => true])->label('Сортировка') ?>
                </div>
            </div>
            <?= $form->field($model, 'required')->checkbox(['label' => 'Обязательный параметр'])->label(false)->hint('') ?>
            <?= $form->field($model, 'default')->textInput(['maxlength' => true])->label('Значение по умолчанию') ?>
            <?= $form->field($model, 'textVariants')->textarea(['rows' => 6])->label('Варианты') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
