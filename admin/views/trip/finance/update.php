<?php

use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\TripFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\BookingHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $trip Trip|null */
/* @var $user_id integer */
/* @var $model TripFinanceForm */

$this->title = 'Изменить оплату ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['/trip/finance', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$mode_confirmation = \Yii::$app->params['mode_confirmation'] ?? false;
$disabled = $mode_confirmation ? ['disabled' => true] : [];


?>
<div class="trip-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость Тура</div>
        <div class="card-body">
            <label>При изменении цены, не забудьте поменять в <a href="<?= Url::to(['/trip/calendar', 'id' => $trip->id])?>">Календаре</a> на будущие даты</label>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'cost_base')->textInput(['maxlength' => true])->label('Цена за Тур')->hint('Без учета проживания и мероприятий') ?>
                </div>
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
                                } ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cancellation')
                                ->textInput(['maxlength' => true])->label('Отмена бронирования *')
                                ->hint('Оставьте пустым, если отмена не предусмотрена, 0 - если в любой день или укажите кол-во дней, за сколько можно отменить бронирование.<br>* при оплате через сайт') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <?= $form->field($model, 'prepay')
                                ->dropdownList(BookingHelper::listPrepay())->label('Предоплата (%):')
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

