<?php

use booking\entities\admin\User;
use booking\forms\booking\tours\CapacityForm;
use booking\forms\booking\tours\ExtraTimeForm;


/* @var $this \yii\web\View */
/* @var $model_extra_time ExtraTimeForm */
/* @var $model_capacity CapacityForm */
/* @var $model_transfer TransferForm */

/* @var $user User */

use booking\forms\booking\tours\TransferForm;
use booking\helpers\CityHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\stays\StayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$js = <<<JS
$('#transferModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); 
  let _id = button.data('id'); 
  let _caption = button.data('caption'); 
  let _cost = button.data('cost'); 
    //console.log(_caption);
  let modal = $(this);
  modal.find('#id').val(_id);
  modal.find('#cost-transfer-caption').html(_caption);
  modal.find('#cost').val(_cost);

})
JS;
$this->registerJs($js);
$this->title = 'Общие параметры и ценообразование';

$this->params['breadcrumbs'][] = ['label' => 'Экскурсии', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-secondary">
    <div class="card-header">Дополнительное время на экскурсии</div>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'action' => '/tour/general/extra-time',
            'enableClientValidation' => false,
        ]); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model_extra_time, 'extra_time_cost')->textInput(['maxlength' => true, 'type' => 'number'])->label('Цена за дополнительный час')->hint('Внимание! При сохранении данные поменяются на все экскурсии!') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model_extra_time, 'extra_time_max')->dropdownList(StayHelper::listNumber(0, 6))->label('Максимальное кол-во дополнительных часов')->hint('При отмене доп.часов удалите стоимость или установите кол-во равное нулю') ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Установить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="card card-secondary pt-3">
    <div class="card-header">Вместительность индивидуальных экскурсий</div>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'action' => '/tour/general/create-capacity',
            'enableClientValidation' => false,
        ]); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model_capacity, 'count')->textInput(['maxlength' => true, 'type' => 'number'])->label('Сколько человек на экскурсию')->hint('Указывайте именно конечное кол-во, а не насколько увеличилось') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model_capacity, 'percent')->textInput(['maxlength' => true, 'min' => 10, 'max' => 1000, 'type' => 'number'])->label('Процент наценки на базовую стоимость') ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <table class="table table-striped table-adaptive w-75">
            <?php foreach ($user->tourCapacities as $capacity): ?>
                <tr>
                    <td><?= $capacity->count ?> человек в экскурсии</td>
                    <td><?= $capacity->percent ?>% наценка на базовую стоимость</td>
                    <td><a href="<?= Url::to(['/tour/general/set-capacity']) ?>" data-method="POST"
                           data-params='{"id":<?= $capacity->id ?>}'>Назначить на все экскурсии</a></td>
                    <td><a href="<?= Url::to(['/tour/general/remove-capacity']) ?>" data-method="POST"
                           data-params='{"id":<?= $capacity->id ?>}'>Удалить</a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header">Установка транзита для экскурсий</div>
    <div class="card-body">
        <label>Если у Вас пешая экскурсия, то Вы можете предоставить клиентам трансфер с основных городов до места
            проведения.</label><br>
        <label>Выберите маршрут, установите стоимость (туда-обратно) и назначьте отдельно для каждой, необходимой,
            экскурсии</label>
        <?php $form = ActiveForm::begin([
            'action' => '/tour/general/create-transfer',
            'enableClientValidation' => false,
        ]); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model_transfer, 'from_id')->dropdownList(CityHelper::list(), ['prompt' => ''])->label('Город нахождения клиента') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model_transfer, 'to_id')->dropdownList(CityHelper::list(), ['prompt' => ''])->label('Город проведения экскурсии') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model_transfer, 'cost')->textInput(['maxlength' => true, 'min' => 10, 'type' => 'number'])->label('Стоимость трансфера туда-обратно') ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <table class="table table-striped table-adaptive w-75">
            <?php foreach ($user->tourTransfers as $transfer): ?>
                <tr>
                    <td><?= $transfer->from->name . ' - ' . $transfer->to->name ?></td>
                    <td><?= CurrencyHelper::stat($transfer->cost) ?></td>
                    <td><a type="button" href="<?= Url::to(['/tour/general/set-capacity']) ?>"
                           data-caption="<?= $transfer->from->name . ' - ' . $transfer->to->name ?>"
                           data-id="<?= $transfer->id ?>"
                           data-cost="<?= $transfer->cost ?>"
                           data-toggle="modal"
                           data-target="#transferModal">Изменить стоимость</a></td>
                    <td><a href="" data-method="POST" data-params='{"id":<?= $transfer->id ?>}'>Удалить</a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cost-transfer-caption">Мета теги</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'action' => '/tour/general/set-transfer',
                'enableClientValidation' => false,
            ]); ?>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="">
                <?= $form->field($model_transfer, 'cost')->textInput(['id' => 'cost', 'name' => 'cost'])->label('Стоимость') ?>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
