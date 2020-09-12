<?php

use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\manage\PreferencesForm;
use booking\helpers\CurrencyHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $user User */
/* @var $model PreferencesForm */

$this->title = Lang::t('Настройки');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-profile">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row pt-4">
        <div class="col">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Региональные настройки') ?></div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Язык') ?>:
                    </div>
                    <div class="col-2">
                        <?= $form->field($model, 'lang')->dropDownList(Lang::listLangsDropDown())->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Предпочитаемая валюта') ?>:
                    </div>
                    <div class="col-2">
                        <?= $form->field($model, 'currency')->dropDownList(CurrencyHelper::listCurrencyDropDown(), ['format' => 'raw'])->label(false) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row pt-4">
        <div class="col">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Предпочтения') ?></div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Курение в номерах') ?>:
                    </div>
                    <div class="col-3">
                        <?= $form->field($model, 'smocking')->dropDownList([
                                0 => Lang::t('Не важно'),
                            1 => Lang::t('Да'),
                            2 => Lang::t('Нет'),
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Количество звезд') ?>:
                    </div>
                    <div class="col-3">
                        <?= $form->field($model, 'stars')->dropDownList([
                            0 => Lang::t('Любое'),
                            2 => Lang::t('2 и выше'),
                            3 => Lang::t('3 и выше'),
                            4 => Lang::t('4 или 5'),
                            5 => Lang::t('5 звезд'),
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Удобства для гостей с ограниченными возможностями') ?>:
                    </div>
                    <div class="col-3">
                        <?= $form->field($model, 'disabled')->checkbox()->label('') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-4">
        <div class="col">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Уведомления') ?></div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Электронная рассылка с предложениями и рекомендациями') ?>:
                    </div>
                    <div class="col-3">

                            <?= $form->field($model, 'newsletter')->checkbox()->label('') ?>

                    </div>
                </div>
            </div>
            <div class="params-item-map">
                <div class="row">
                    <div class="col-6">
                        <?= Lang::t('Получать уведомления на почту') ?>:
                    </div>
                    <div class="col-3">
                        <?= $form->field($model, 'notice_dialog')->checkbox()->label('') ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Lang::t('Сохранить'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
