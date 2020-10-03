<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post \shop\entities\blog\post\Post */
/* @var $items \frontend\widgets\blog\CommentView[] */
/* @var $count integer */
/* @var $commentForm \shop\forms\blog\CommentForm */
?>

<div id="comments" class="inner-bottom-xs">
    <h2>Комментарии</h2>
    <?php foreach ($items as $item): ?>
        <?= $this->render('_comment', ['item' => $item]) ?>
    <?php endforeach; ?>
</div>

<?php if (\Yii::$app->user->isGuest) :?>
    <div class="card">
        <div class="card-body">
            Пожалуйста, <?= Html::a('авторизуйтесь', ['/auth/auth/login'])?> для написания комментария
        </div>
    </div>
<?php else: ?>
<div id="reply-block" class="leave-reply">
    <?php $form = ActiveForm::begin([
        'action' => ['comment', 'id' => $post->id],
    ]); ?>

    <?= Html::activeHiddenInput($commentForm, 'parentId') ?>
    <?= $form->field($commentForm, 'text')->textarea(['rows' => 5])->label('Текст') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php endif; ?>

<?php $this->registerJs("
    jQuery(document).on('click', '#comments .comment-reply', function () {
        var link = jQuery(this);
        var form = jQuery('#reply-block');
        var comment = link.closest('.comment-item');
        jQuery('#commentform-parentid').val(comment.data('id'));
        form.detach().appendTo(comment.find('.reply-block:first'));
        return false;
    });
"); ?>


 