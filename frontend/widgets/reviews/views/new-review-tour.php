<?php
/* @var $reviewForm \booking\forms\booking\ReviewForm */
/* @var $tour_id int */

use booking\entities\Lang;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>
<button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
        data-target="#collapse-review"
        aria-expanded="false" aria-controls="collapse-review">
    <?= Lang::t('Оставить отзыв') ?>
</button>
<div class="collapse" id="collapse-review">
    <?php $form = ActiveForm::begin(['action' => ['/tour/view', 'id' => $tour_id]]) ?>
    <?= $form->field($reviewForm, 'vote')->dropDownList($reviewForm->voteList(), ['prompt' => '--- ' . Lang::t('Выберите') . ' ---'])->label(Lang::t('Рейтинг')); ?>

    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label(Lang::t('Отзыв')); ?>

    <div class="form-group">
        <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn-lg btn-primary btn-lg btn-block']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
