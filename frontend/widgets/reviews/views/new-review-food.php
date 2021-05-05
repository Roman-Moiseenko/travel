<?php
/* @var $reviewForm ReviewFoodForm */
/* @var $id int */

/* @var $action string */

use booking\entities\Lang;
use booking\forms\foods\ReviewFoodForm;
use frontend\widgets\design\BtnReview;use frontend\widgets\design\BtnSend;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6">
        <?= BtnReview::widget(['caption' => 'Оставить отзыв', 'target_id' => 'collapse-review'])?>
    </div>
</div>

<div class="collapse pt-4" id="collapse-review">
    <?php $form = ActiveForm::begin([
       // 'action' => [$action, 'id' => $id],
        'enableClientValidation' => false,
    ]) ?>
    <label>Ваша оценка:</label>
    <div class="star-rating">
        <div class="star-rating__wrap">
            <input class="star-rating__input" id="star-rating-5" type="radio" name="ReviewFoodForm[vote]" value="5">
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
            <input class="star-rating__input" id="star-rating-4" type="radio" name="ReviewFoodForm[vote]" value="4">
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
            <input class="star-rating__input" id="star-rating-3" type="radio" name="ReviewFoodForm[vote]" value="3">
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
            <input class="star-rating__input" id="star-rating-2" type="radio" name="ReviewFoodForm[vote]" value="2">
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
            <input class="star-rating__input" id="star-rating-1" type="radio" name="ReviewFoodForm[vote]" value="1">
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6">
    <?= $form->field($reviewForm, 'username')->textInput([])->label(Lang::t('Ваше Имя')); ?>
        </div>
        <div class="col-md-3 col-sm-6">
            <?= $form->field($reviewForm, 'email')->textInput([])->label(Lang::t('Ваш email'))->hint(Lang::t('Не публикуется')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label(Lang::t('Комментарий') . ':'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
        <?= BtnSend::widget(['caption' => 'Отправить'])?>
        </div>
    </div>

    <?php ActiveForm::end() ?>
</div>
