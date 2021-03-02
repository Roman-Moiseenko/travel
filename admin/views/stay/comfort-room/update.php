<?php

use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use booking\entities\booking\stays\Photo;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayComfortRoomForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model StayComfortRoomForm */
/* @var $stay Stay */



$this->title = 'Удобства в комнатах ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилища', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

$categories = ComfortRoomCategory::find()->all();
?>
<div class="comfort-room">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden'])->label(false) ?>
    <?php foreach ($categories as $category): ?>
        <div class="card card-secondary">
            <div class="card-header"><i class="<?= $category->image ?>"></i> <?= $category->name ?></div>
            <div class="card-body">
                <?php foreach ($model->assignComfortsRoom as $i => $assignComfortRoomForm): ?>
                <?= $this->render('_comfort', [
                        'assignComfortRoomForm' => $assignComfortRoomForm,
                        'category' => $category,
                        'form' => $form,
                        'i' => $i,

                    ]);?>

                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="form-group p-2">
        <?php if ($stay->filling) {
            echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


