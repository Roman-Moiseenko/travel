<?php

use booking\entities\foods\Food;
use booking\forms\booking\PhotosForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $food Food */
/* @var $photosForm PhotosForm */

$this->title = 'Фотографии ' . $food->name;
$this->params['id'] = $food->id;
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['/info/foods/food']];
$this->params['breadcrumbs'][] = ['label' => $food->name, 'url' => ['/info/foods/food/view', 'id' => $food->id]];
$this->params['breadcrumbs'][] = 'Фотографии';
?>
<div class="food-photo">

    <div class="card card-secondary" id="photos">
        <div class="card-header with-border">Фотографии</div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($food->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $food->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $food->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $food->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                $photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

            <?= $form->field($photosForm, 'files[]')
                ->label(false)
                ->widget(FileInput::class, [
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['jpg', 'jpeg'],
                    ],
                ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

