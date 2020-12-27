<?php

use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\admin\PersonalForm;
use booking\helpers\country\CountryHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $user User */
/* @var $model PersonalForm */

$this->title = Lang::t('Редактировать');
$this->params['breadcrumbs'][] = ['label' => Lang::t('Профиль'), 'url' => Url::to(['/cabinet/profile', 'id' => $user->id])];;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="container-hr">
        <hr/>
        <div class="text-left-hr"><?= Lang::t('Основные') ?></div>
    </div>
    <div class="row">
        <div class="col-md-6" style="text-align: center">
            <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                'language' => Lang::current(),
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'initialPreview' => [
                        $user->personal->getThumbFileUrl('photo', 'profile'),
                    ],
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => true,
                    'showRemove' => false,
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model->fullname, 'surname')->textInput()->label(Lang::t('Фамилия')); ?>
            <?= $form->field($model->fullname, 'firstname')->textInput()->label(Lang::t('Имя')); ?>
            <?= $form->field($model->fullname, 'secondname')->textInput()->label(Lang::t('Отчество')); ?>
            <?= $form->field($model, 'datebornform')->label(Lang::t('Дата рождения'))->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_INPUT,
                'language' => 'ru',

                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'autoclose' => true,
                ]
            ]); ?>
            <?= $form->field($model, 'phone')->textInput()->label(Lang::t('Телефон')); ?>
        </div>
    </div>
    <div class="container-hr">
        <hr/>
        <div class="text-left-hr"><?= Lang::t('Адрес') ?></div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model->address, 'country')->dropDownList(CountryHelper::listCountry(), ['prompt' => ''])->label(Lang::t('Страна')); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model->address, 'index')->textInput()->label(Lang::t('Индекс')); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model->address, 'town')->textInput()->label(Lang::t('Город')); ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model->address, 'address')->textInput()->label(Lang::t('Адрес'))->hint(Lang::t('Улица, Дом, Кв')); ?>
        </div>
    </div>
    <div class="row">
        <?= $form->field($model, 'agreement')->checkbox()
            ->label(Lang::t('Согласие на обработку Персональных данных'))
            ->hint(
                Lang::t('Подтверждая данный выбор, я принимаю ') .
                Html::a(Lang::t('Политику конфиденциальности'), Url::to(['/policy']), ['target' => '_blank'])
            ); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Lang::t('Сохранить'), ['class' => 'btn-lg btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
