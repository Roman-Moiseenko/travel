<?php

use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\Photo;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayComfortForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;

/* @var $model StayComfortForm */
/* @var $stay Stay */


$this->title = 'Удобства ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

$categories = ComfortCategory::find()->all();
?>
<div class="comfort">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden'])->label(false) ?>
    <?php foreach ($categories as $category): ?>
        <div class="card card-secondary">
            <div class="card-header"><i class="<?= $category->image ?>"></i> <?= $category->name ?></div>
            <div class="card-body">
                <?php foreach ($model->assignComforts as $i => $assignComfortForm): ?>
                    <?php $comfort = $assignComfortForm->_comfort;
                    if ($comfort->category_id == $category->id): ?>
                        <div class="d-flex">
                            <?php
                            echo '<div class="px-2">' . $form
                                    ->field($assignComfortForm, '[' . $i . ']checked')
                                    ->checkbox()
                                    ->label($comfort->name) . '</div>';
                            echo '<div class="px-2">' . $form
                                    ->field($assignComfortForm, '[' . $i . ']comfort_id')
                                    ->textInput(['type' => 'hidden'])
                                    ->label(false) . '</div>';
                            if ($comfort->paid)
                                echo '<div class="px-2">' . $form->field($assignComfortForm, '[' . $i . ']pay')->checkbox()->label('Платно') . '</div>';
                            if ($comfort->photo){
                                echo '<div class="px-2">' .
                                    $form->field($assignComfortForm, '[' . $i . ']file')->widget(FileInput::class, [
                                        'language' => 'ru',
                                        'options' => [
                                            'accept' => 'image/*',
                                            'multiple' => false,
                                        ],
                                        'pluginOptions' => [
                                            'initialPreviewAsData' => true,
                                            'overwriteInitial' => true,
                                            'showRemove' => false,
                                            'showPreview' => false,
                                            'showCancel' => false,
                                            'showCaption' => false,
                                            'showUpload' => false,
                                            'browseLabel' => '',
                                            'browseClass' => 'btn btn-outline-primary btn-file',
                                        ],
                                    ])->label(false) .
                                    '</div>';
                                if ($assignComfortForm->_assignComfort) {
                                    echo '<a class="up-image" href="#"><i class="fas fa-file-image" style="color: #0c525d; font-size: 28px;"></i>'.
                                        '<span><img src="' . $assignComfortForm->_assignComfort->getThumbFileUrl('file','thumb') . '" alt=""></span>'.
                                        '</a>';
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
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


