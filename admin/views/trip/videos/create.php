<?php

use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\TripCommonForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TripCommonForm */
/* @var $trip Trip|null */

$this->title = 'Добавить Видео';
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Видеообзоры', 'url' => ['/trip/videos', 'id' => $trip->id]];
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
        <?php if ($trip->filling) {
            echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        }
        ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

