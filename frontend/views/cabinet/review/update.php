<?php

use booking\entities\Lang;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model \booking\forms\booking\ReviewForm */
/* @var $review \booking\entities\booking\BaseReview */
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->title = Lang::t('Изменить отзыв на') .  ' ' . $review->getName();
$this->params['breadcrumbs'][] = ['label' =>  Lang::t('Мои отзывы'), 'url' => Url::to(['cabinet/review/index'])];;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="update-review">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'vote')->dropDownList($model->voteList(), ['prompt' => '--- ' . Lang::t('Выберите') .' ---'])->label( Lang::t('Рейтинг')); ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 7])->label( Lang::t('Отзыв')); ?>
    <div class="form-group">
        <?= Html::submitButton( Lang::t('Сохранить'), ['class' => 'btn-primary btn-lg btn-block']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
