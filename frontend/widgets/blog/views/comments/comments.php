<?php

use booking\entities\blog\post\Post;
use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\blog\CommentForm;
use frontend\widgets\design\BtnSave;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post Post */
/* @var $items \frontend\widgets\blog\CommentView[] */
/* @var $count integer */
/* @var $commentForm CommentForm */
/* @var $user User */

?>

<div id="comments" class="inner-bottom-xs">
    <h2><?= Lang::t('Комментарии') ?></h2>
    <?php foreach ($items as $item): ?>
        <?= $this->render('_comment', ['item' => $item]) ?>
    <?php endforeach; ?>
</div>

<?php if ($user) :?>
    <div id="reply-block" class="leave-reply">
        <?php $form = ActiveForm::begin([
            'action' => ['comment', 'id' => $post->id],
        ]); ?>

        <?= Html::activeHiddenInput($commentForm, 'parentId') ?>
        <?= $form->field($commentForm, 'text')->textarea(['rows' => 5])->label(Lang::t('Текст')) ?>

        <div class="form-group">
            <?= BtnSave::widget() ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <?= Lang::t('Пожалуйста') . ', ' . Html::a(Lang::t('авторизуйтесь'), ['/auth/auth/login']) . ' ' . Lang::t('для написания комментария') ?>
        </div>
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


 