<?php

use booking\entities\shops\products\Product;
use booking\forms\shops\ProductForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\shops\CategoryHelper;
use booking\helpers\shops\DeliveryHelper;
use booking\helpers\shops\ManufacturedHelper;
use booking\helpers\shops\MaterialHelper;
use booking\helpers\shops\ShopTypeHelper;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ProductForm */
/* @var $product Product */


?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название (En)') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)') ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card card-secondary">
    <div class="card-header with-border">Ценообразование</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'cost')->textInput(['type' => 'number'])->label('Стоимость') ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'quantity')->textInput(['type' => 'number'])->label('Количество')
                        ->hint('Укажите кол-во товара в наличии, если товар постоянно поступает, укажите большое число, например 9999') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'discount')->textInput(['type' => 'number'])->label('Скидка для онлайн (%)') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'request_available')->checkbox([])->label('Требуется подтверждение продавца при продаже') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Характеристики</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'weight')->textInput(['type' => 'number', 'min' => '1'])->label('Вес (г)')->hint('Используются для расчета стоимости доставки') ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model->size, 'width')->textInput(['type' => 'number', 'min' => '1'])->label('Ширина (см)') ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model->size, 'height')->textInput(['type' => 'number', 'min' => '1'])->label('Высота (см)') ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model->size, 'depth')->textInput(['type' => 'number', 'min' => '1'])->label('Глубина (см)') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'collection')->textInput([])->label('Коллекция/серия') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'article')->textInput([])->label('Артикул')->hint('Артикул в Вашем магазине') ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'color')->textInput([])->label('Цвет') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'materials')->checkboxList(MaterialHelper::list())->label('Материал') ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'category_id')->dropdownList(CategoryHelper::list(), ['prompt' => ''])->label('Категория') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'manufactured_id')->dropdownList(ManufacturedHelper::list(), ['prompt' => ''])->label('Тип производства') ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'deadline')->textInput(['type' => 'number'])->label('Срок производства (дней)') ?>
                </div>
            </div>

        </div>
    </div>

    <div class="card card-secondary" id="photos">
        <div class="card-header with-border">Фотографии</div>
        <div class="card-body">
            <label>Для более качественного отображения, фотографии должны иметь размер не менее 1280х720</label>
            <div class="row">
                <?php if ($product) foreach ($product->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
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


            <?= $form->field($model->photo, 'files[]')
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

    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>