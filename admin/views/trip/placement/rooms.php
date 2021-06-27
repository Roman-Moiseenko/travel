<?php

use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use booking\entities\booking\trips\placement\MealsAssignment;
use booking\entities\booking\trips\placement\Placement;
use booking\entities\booking\trips\placement\room\Room;
use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\RoomForm;
use booking\helpers\stays\StayHelper;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model RoomForm */
/* @var $trip Trip|null */
/* @var $placement Placement|null */
/* @var $room Room */
$this->title = 'Номера для  ' . $placement->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Проживание', 'url' => ['/trip/placement/index', 'id' => $trip->id, 'placement_id' => $placement->id]];
$this->params['breadcrumbs'][] = ['label' => $placement->name, 'url' => ['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement->id]];
$this->params['breadcrumbs'][] = 'Номера';

$categories = ComfortRoomCategory::find()->all();
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'name')->textInput()->label('Название') ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'name_en')->textInput()->label('Название (En)') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'quantity')->dropdownList(StayHelper::listNumber(1, 99))->label('Количество номеров (для апартаментов = 1)') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'cost')->textInput()->label('Стоимость') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'capacity')->dropdownList(StayHelper::listNumber(1, 10))->label('Вместительность (чел)') ?>
                </div>
            </div>
            <?= $form->field($model, 'shared')->checkbox()->label('Общий номер (цена за чел)') ?>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'meals_id')
                        ->dropdownList(ArrayHelper::map(
                            $placement->mealsAssignment,
                            function (MealsAssignment $assign) {
                                return $assign->meal_id;
                            },
                            function (MealsAssignment $assign) {
                                return $assign->meals->mark;
                            }),
                            ['prompt' => '']
                        )->label('Выберите питание')->hint('Учтанавливается в том случае, если другого питания или без питания не предусмотрено') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary" id="photos">
        <div class="card-header with-border">Фотографии</div>
        <div class="card-body">
            <label>Для более качественного отображения, фотографии должны иметь размер не менее 1280х720</label>
            <?php if ($room): ?>
                <div class="row">
                    <?php foreach ($room->photos as $photo): ?>
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
            <?php endif; ?>

            <?= $form->field($model->photos, 'files[]')
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
        </div>
    </div>

    <div class="comfort">
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

                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>