<?php

use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\BookingHelper;
use booking\helpers\tours\TourHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tour Tour */
/* @var $model TourFinanceForm */


$this->title = 'Изменить оплату ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['/tour/finance', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$mode_confirmation = \Yii::$app->params['mode_confirmation'] ?? false;
$disabled = $mode_confirmation ? ['disabled' => true] : [];
?>
<div class="tours-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?php if ($tour->params->private): ?>
                <div class="col-md-6">
                    <?= $form->field($model->baseCost, 'adult')->textInput(['maxlength' => true])->label('Цена за экскурсию') ?>
                </div>
            <?php else: ?>
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'adult')->textInput(['maxlength' => true])->label('Билет для взрослых') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'child')->textInput(['maxlength' => true])->label('Билет для детей') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'preference')->textInput(['maxlength' => true])->label('Билет для льготных граждан') ?>
            </div>
            <?php endif; ?>
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

