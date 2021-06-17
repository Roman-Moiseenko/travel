<?php

use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\TripCommonForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TripCommonForm */
/* @var $trip Trip */

$this->title = 'Редактировать ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="trip-update">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form
    ]) ?>
    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

