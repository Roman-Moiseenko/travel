<?php

use booking\entities\booking\cars\Car;
use booking\forms\booking\cars\CarFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\BookingHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $car Car */
/* @var $model CarFinanceForm */


$this->title = 'Изменить оплату ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['/car/finance', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$mode_confirmation = \Yii::$app->params['mode_confirmation'] ?? false;
$disabled = $mode_confirmation ? ['disabled' => true] : [];
?>
<div class="cars-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model, 'cost')->textInput(['maxlength' => true])->label('Цена проката в сутки') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'deposit')->textInput(['maxlength' => true])->label('Залог') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'quantity')->textInput(['maxlength' => true])->label('Кол-во средств данной модели') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'discount_of_days')->textInput(['maxlength' => true])->label('Скидка при прокате более 3 дней (%)') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация') ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cancellation')
                                ->textInput(['maxlength' => true])->label('Отмена бронирования *')
                                ->hint('Оставьте пустым, если отмена не предусмотрена, 0 - если в любой день или укажите кол-во дней, за сколько можно отменить бронирование.<br>* при оплате через сайт') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'pay_bank')
                                ->checkbox($disabled)->label('Комиссию банка оплачивает Провайдер')
                                ->hint('Для повышения лояльности Клиентов, старайтесь самостоятельно оплачивать комиссию банка.') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'check_booking')
                                ->radioList(BookingHelper::listCheck(), ['itemOptions' => $disabled])->label('Способ оплаты:')
                                 ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

