<?php

use booking\entities\booking\cars\Car;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\cars\CarFinanceForm;
use booking\forms\booking\stays\StayFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\BookingHelper;
use booking\helpers\stays\StayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */
/* @var $model StayFinanceForm */


$this->title = 'Изменить оплату ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['/stay/finance', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$mode_confirmation = \Yii::$app->params['mode_confirmation'] ?? false;
$disabled = $mode_confirmation ? ['disabled' => true] : [];
?>
<div class="stay-finance">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model, 'cost_base')->textInput(['maxlength' => true])->label('Базовая цена за 1 ночь') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'guest_base')->dropdownList(StayHelper::listNumber(1, $stay->params->guest))->label('Количество гостей, включенных в стоимость') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'cost_add')->textInput(['maxlength' => true])->label('Цена за каждого дополнительного гостя в сутки')->hint('За каждого сверх базового значения') ?>
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
                            <?php if (count(AdminUserHelper::listLegals()) == 0) {
                                echo Html::a('Добавить организацию', Url::to(['/legal/create']), ['class' => 'btn btn-warning']);
                            } else {
                                echo $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация');
                            } ?>                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cancellation')
                                ->textInput(['maxlength' => true])->label('Отмена бронирования *')
                                ->hint('Оставьте пустым, если отмена не предусмотрена, 0 - если в любой день или укажите кол-во дней, за сколько можно отменить бронирование.<br>* при оплате через сайт') ?>
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
        <?php if (count(AdminUserHelper::listLegals()) == 0) {
            echo Html::submitButton('Добавьте организацию!', ['class' => 'btn btn-success', 'disabled' => 'disabled']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

