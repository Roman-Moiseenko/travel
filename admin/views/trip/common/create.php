<?php

use booking\forms\booking\trips\TripCommonForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TripCommonForm */

$this->title = 'Создать Тур';
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form
    ])?>

    <div class="form-group p-2">
        <?= Html::submitButton('Далее >>', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

