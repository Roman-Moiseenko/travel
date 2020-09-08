<?php

/* @var $dialog Dialog */

/* @var $typeDialog integer */

use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Lang::t('Сообщение');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="dialog-new">
    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'theme_id')->dropDownList(ThemeDialog::getList($typeDialog), ['prompt' => '--- ' . Lang::t('Выберите') . ' ---'])->label(Lang::t('Тема сообщения')); ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 7])->label(Lang::t('Сообщение')); ?>
        </div>
    </div>

    <div class="input-group">
        <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

