<?php


use booking\entities\booking\cars\Type;
use booking\forms\booking\cars\CharacteristicForm;
use booking\helpers\cars\CharacteristicHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $type Type */
/* @var $model CharacteristicForm */

$this->title = 'Создать Характеристику';
$this->params['breadcrumbs'][] = ['label' => 'Категории авто', 'url' => Url::to(['guides/car-type/index'])];
$this->params['breadcrumbs'][] = ['label' => $type->name, 'url' => Url::to(['guides/car-type/view', 'id' => $type->id])];
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
