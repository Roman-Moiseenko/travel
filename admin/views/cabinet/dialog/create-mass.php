<?php

/* @var $dialog Dialog */

/* @var $typeDialog integer */
/* @var $calendar CostCalendar */

use booking\entities\booking\cars\CostCalendar;
use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\helpers\DialogHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Lang::t('Создать рассылку сообщений');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialog-caption">

        <div class="caption pb-2"><?= '№ бронирования: '?></div>
</div>
<div class="dialog-new">
    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'theme_id')->dropDownList(DialogHelper::getList($typeDialog), ['prompt' => '--- ' . Lang::t('Выберите') . ' ---'])->label(Lang::t('Тема сообщения')); ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 7])->label(Lang::t('Сообщение')); ?>
        </div>
    </div>

    <div class="input-group">
        <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

