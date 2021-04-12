<?php



use booking\entities\blog\map\Maps;
use booking\entities\blog\map\Point;
use booking\forms\blog\map\PointForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $map Maps */
/* @var $model PointForm */
/* @var $point Point */

$this->title = 'Редактировать точку: ' . $point->caption;
$this->params['breadcrumbs'][] = ['label' => 'Карты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $map->name, 'url' => Url::to(['view', 'id' => $map->id])];
//$this->params['breadcrumbs'][] = ['label' => $point->caption, 'url' => Url::to(['view', 'id' => $map->id])];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="point-add">
    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-secondary">
        <div class="card-header">Основные параметры</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
            <?= $form->field($model, 'caption')->textInput()->label('Заголовок'); ?>
            <?= $form->field($model, 'link')->textInput()->label('Ссылка на статью'); ?>
                </div>
                <div class="col-sm-6">
            <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                'language' => 'ru',
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'initialPreview' => [
                        $point->getUploadedFileUrl('photo'),
                    ],
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => true,
                    'showRemove' => false,
                ],
            ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header">Карта</div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <?= $form->field($model->geo, 'address')->
                    textInput(['maxlength' => true, 'style' => 'width:100%'])->label(false) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model->geo, 'latitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model->geo, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div id="map" style="width: 100%; height: 600px"></div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
