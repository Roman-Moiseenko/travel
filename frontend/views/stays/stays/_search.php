<?php

use booking\entities\booking\stays\rules\Rules;
use booking\entities\Lang;
use booking\forms\booking\cars\SearchCarForm;
use booking\forms\booking\stays\search\SearchStayForm;
use booking\helpers\cars\CarTypeHelper;
use booking\helpers\CityHelper;
use booking\helpers\stays\StayHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model SearchStayForm */

$layout = <<< HTML
<div class="row">
    <div class="col">
        <div class="form-group">
            <label class="mb-0" for="searchstayform-date_from">Дата заезда</label>

            {input1}
  
        </div>
    </div>
</div>
<div class="row">
    <div class="col">   
        <div class="form-group">    
            <label class="mb-0" for="searchstayform-date_to">Дата отъезда</label>
            {input2}
        </div>
    </div>
</div>
HTML;
?>

<?php $form = ActiveForm::begin([
        'id' => 'search-stay-form',
    'action' => '/' . Lang::current() . '/stays',
    'method' => 'GET',
    'enableClientValidation' => false,
]) ?>
<div class="leftbar-search-stays">
    <div class="block-search-stay">
        <div class="row">
            <div class="col">
                <?= $form->field($model, 'city')
                    ->textInput(['class' => 'form-control form-control-xl'])
                    ->label('Город' . ':', ['class' => '']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="not-flex">
                    <?= DatePicker::widget([
                        'id' => 'stay-range',

                        'model' => $model,
                        'attribute' => 'date_from',
                        'attribute2' => 'date_to',
                        'type' => DatePicker::TYPE_RANGE,
                        'layout' => $layout,
                        'separator' => '',
                        'size' => 'lg',
                        'options' => ['class' => 'form-control form-control-xl', 'readonly' => 'readonly', 'style' => 'text-align: left;'],
                        'options2' => ['class' => 'form-control form-control-xl', 'readonly' => 'readonly', 'style' => 'text-align: left;'],
                        'language' => Lang::current(),
                        'pluginOptions' => [
                            'startDate' => '+1d',
                            'todayHighLight' => true,
                            'autoclose' => true,
                            'format' => 'DD, dd MM yyyy',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col form-inline">
                <?= $form->field($model, 'guest')
                    ->dropDownList(StayHelper::listGuest(), ['class' => 'change-attr form-control form-control-xl'])
                    ->label(false); ?>
                <?= $form->field($model, 'children')
                    ->dropDownList(StayHelper::listChildren(), ['class' => 'change-attr form-control form-control-xl ml-1'])
                    ->label(false); ?>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col text-center">
                <button class="btn-lg btn-primary" type="submit" style="width: 50%;"><?= Lang::t('Найти') ?></button>
            </div>
        </div>
    </div>
</div>
<?php
    //TODO Сортировка по бюджету
    // если установлены даты
    // цена за ночь по выбранному количеству гостей
?>
<div class="p-3"></div>
<div class="leftbar-search-stays-fields">
    <div class="search-block">
        <div class="search-name">Спальни</div>
            <div class="search-fields">
                <?= $form->field($model, 'bedrooms')
                    ->checkboxList(
                            [1 => 'Одна спальня', 2 => 'Две и более', 3 => 'Три и более', 4 => 'Четыре и более'], ['onchange' => "$('#search-stay-form').submit();"])
                    ->label(false) ?>
            </div>
    </div>
    <div class="search-block">
        <div class="search-name">Расстояние до центра</div>
        <div class="search-fields">
            <?= $form->field($model, 'to_center')->checkboxList([1 => 'Менее 1 км', 3 => 'Менее 3 км', 5 => 'Менее 5 км'], ['onchange' => "$('#search-stay-form').submit();"])->label(false) ?>
        </div>
    </div>
    <div class="search-block">
        <div class="search-name">Вид жилья</div>
        <?php foreach ($model->categories as $i => $category): ?>
            <div class="search-fields">
                <?= $form->field($category, '[' . $i . ']checked')->checkbox(['onchange' => "$('#search-stay-form').submit();"])->label($category->name) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="search-block">
        <div class="search-name">Удобства</div>
        <?php foreach ($model->comforts as $i => $comfort): ?>
        <div class="search-fields">
            <?= $form->field($comfort, '[' . $i . ']checked')->checkbox(['onchange' => "$('#search-stay-form').submit();"])->label($comfort->name) ?>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="search-block last-block">
        <div class="search-name">Удобства в номерах</div>
        <?php foreach ($model->comforts_room as $i => $comfort_room): ?>
        <div class="search-fields">
            <?= $form->field($comfort_room, '[' . $i . ']checked')->checkbox(['onchange' => "$('#search-stay-form').submit();"])->label($comfort_room->name) ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
