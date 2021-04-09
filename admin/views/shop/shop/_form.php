<?php


use booking\entities\shops\DeliveryCompany;
use booking\forms\booking\tours\TourCommonForm;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\shops\DeliveryHelper;
use booking\helpers\shops\ShopTypeHelper;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ShopCreateForm */


?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название магазина') ?>
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
                            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название магазина (En)') ?>
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
        <div class="card-header with-border">Дополнительно</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'type_id')->dropDownList(ShopTypeHelper::list(), ['prompt' => ''])->label('Тип') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header with-border">Доставка</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'onCity')->checkbox()->label('Доставка по городу') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'costCity')->textInput(['type' => 'number'])->label('Стоимсоть доставки по городу') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'minAmountCity')->textInput(['type' => 'number'])->label('Мин.сумма доставки по городу') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'onPoint')->checkbox()->label('Имеется точка выдачи в городе') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model->delivery->addressPoint, 'address')->textInput()->label('Адрес выдачи') ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model->delivery->addressPoint, 'latitude')->textInput()->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model->delivery->addressPoint, 'longitude')->textInput()->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'period')->textInput(['type' => 'number'])->label('Сколько раз в неделю осуществляется доставка')->hint('0 - в день заказа') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model->delivery, 'deliveryCompany')->checkboxList(DeliveryHelper::list())->label('Транспортные компании') ?>
                </div>

            </div>
        </div>
    </div>

    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>