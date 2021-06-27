<?php


/* @var $this \yii\web\View */

use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\TripParamsForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $trip Trip|null */
/* @var $model TripParamsForm */
$this->title = 'Изменить параметры ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['/trip/params', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="card card-secondary">
    <div class="card-header with-border">Основные параметры</div>
    <div class="card-body">
        <?= $form->field($model, 'duration')->textInput()->label('Длительность тура')->hint('Укажите количество ночей') ?>
        <?= $form->field($model, 'transfer')->textInput()->label('Трансфер')->hint('Оставьте пустым, если не предоставляется, 0 - входит в стоимость тура или укажите цену, если предоставляется как отдельная услуга!') ?>
        <?= $form->field($model, 'capacity')->textInput()->label('Количество мест в туре')->hint('Оставьте пустым, если ограничено количеством мест проживания') ?>
        <div class="form-group">
            <?php if ($trip->filling) {
                echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
            } else {
                echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
            }
            ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
