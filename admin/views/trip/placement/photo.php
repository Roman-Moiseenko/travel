<?php

use booking\entities\booking\trips\placement\Placement;
use booking\entities\booking\trips\Trip;
use booking\forms\booking\PhotosForm;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $placement Placement */
/* @var $trip Trip */
/* @var $model PhotosForm */

$this->title = 'Фото для  ' . $placement->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Проживание', 'url' => ['/trip/placement/index', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => $placement->name, 'url' => ['/trip/placement/view', 'id' => $placement->id]];
$this->params['breadcrumbs'][] = 'Фото';

?>

<div class="card card-secondary" id="photos">
    <div class="card-header with-border">Фотографии</div>
    <div class="card-body">
        <label>Для более качественного отображения, фотографии должны иметь размер не менее 1280х720</label>
        <div class="row">
            <?php foreach ($placement->photos as $photo): ?>
                <div class="col-md-2 col-xs-3" style="text-align: center">
                    <div class="btn-group">
                        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $placement->id, 'photo_id' => $photo->id], [
                            'class' => 'btn btn-default',
                            'data-method' => 'post',
                        ]); ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $placement->id, 'photo_id' => $photo->id], [
                            'class' => 'btn btn-default',
                            'data-method' => 'post',
                            'data-confirm' => 'Remove photo?',
                        ]); ?>
                        <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $placement->id, 'photo_id' => $photo->id], [
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

        <?= $form->field($model, 'files[]')
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
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
