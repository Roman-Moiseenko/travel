<?php

use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\Photo;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayComfortForm;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;

/* @var $model StayComfortForm */
/* @var $stay Stay */


//$url = \Yii::$app->urlManager->baseUrl . '/images/flags/';
$format = <<<SCRIPT
function format(state) {
    if (!state.id) return state.text;   
    src = state.text;
    return '<img class="flag" src="' + src + '"/>';
}
SCRIPT;
$escape = new JsExpression("function(m) { return m; }");
$this->registerJs($format, View::POS_HEAD);

$this->title = 'Удобства ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилища', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

$categories = ComfortCategory::find()->all();
?>
<div class="comfort">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden'])->label(false) ?>
    <?php foreach ($categories as $category): ?>
        <div class="card card-secondary">
            <div class="card-header"><i class="<?= $category->image ?>"></i> <?= $category->name ?></div>
            <div class="card-body">
                <?php foreach ($model->assignComforts as $i => $assignComfortForm): ?>
                    <?php $comfort = $assignComfortForm->_comfort;
                    if ($comfort->category_id == $category->id): ?>
                        <div class="d-flex">
                            <?php
                            echo '<div class="px-2">' . $form
                                    ->field($assignComfortForm, '[' . $i . ']comfort_id')
                                    ->checkbox(['value' => $comfort->id])
                                    ->label($comfort->name) . '</div>';
                            if ($comfort->paid)
                                echo '<div class="px-2">' . $form->field($assignComfortForm, '[' . $i . ']pay')->checkbox()->label('Платно') . '</div>';
                            if ($comfort->photo)
                                echo '<div class="px-2">' . Select2::widget([
                                        'name' => $assignComfortForm->formName() . '[' . $i . '][photo_id]',
                                        'data' => ArrayHelper::map($stay->photos,
                                            function (Photo $photo) {
                                                return $photo->id;
                                            },
                                            function (Photo $photo) {
                                                return $photo->getThumbFileUrl('file', 'stays_list');
                                            }),
                                        'size' => Select2::LARGE,
                                        'theme' => Select2::THEME_MATERIAL,
                                        'value' => $assignComfortForm->photo_id,
                                        'options' => ['placeholder' => 'Выберите фото ...', 'height' => '150px'],
                                        'pluginOptions' => [
                                            'templateResult' => new JsExpression('format'),
                                            'templateSelection' => new JsExpression('format'),
                                            'escapeMarkup' => $escape,
                                            'allowClear' => true,

                                        ]]) . '</div>';
                            ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="form-group p-2">
        <?php if ($stay->filling) {
            echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        }
         ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


