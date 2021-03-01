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
                    <?php $comfort = $assignComfortRoomForm->_comfort;
                    if ($comfort->category_id == $category->id): ?>
                        <div class="d-flex">
                            <?php
                            echo '<div class="px-2">' . $form
                                    ->field($assignComfortRoomForm, '[' . $i . ']checked')
                                    ->checkbox([])
                                    ->label($comfort->name) . '</div>';
                            echo $form
                                ->field($assignComfortRoomForm, '[' . $i . ']comfort_id')
                                ->textInput(['type' => 'hidden'])
                                ->label(false);
                            if ($comfort->photo) {
                                echo '<div class="px-2">' .
                                    $form->field($assignComfortRoomForm, '[' . $i . ']file')->widget(FileInput::class, [
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
                                if ($assignComfortRoomForm->_assignComfort) {
                                    echo '<a class="up-image" href="#"><i class="fas fa-file-image" style="color: #0c525d; font-size: 28px;"></i>'.
                                            '<span><img src="' . $assignComfortRoomForm->_assignComfort->getThumbFileUrl('file','thumb') . '" alt=""></span>'.
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


