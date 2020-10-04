<?php

/* @var $item \frontend\widgets\blog\CommentView */

use booking\entities\Lang; ?>

<div class="comment-item" data-id="<?= $item->comment->id ?>">
    <div class="panel panel-default">
        <div class="panel-heading" style="height: 36px">
                <div class="pull-left">
                    <?= $item->comment->user->username; ?>
                </div>
                <div class="pull-right">
                    <?= Yii::$app->formatter->asDatetime($item->comment->created_at) ?>
                </div>
        </div>
        <div class="panel-body">
            <p class="comment-content">
                <?php if ($item->comment->isActive()): ?>
                    <?= Yii::$app->formatter->asNtext($item->comment->text) ?>
                <?php else: ?>
                    <i><?= Lang::t('Комментарий удален') ?>.</i>
                <?php endif; ?>
            </p>
            <div>
                <div class="pull-left">
                    <?= '';//Yii::$app->formatter->asDatetime($item->comment->created_at) ?>
                </div>
                <div class="pull-right">
                    <span class="comment-reply"><?= Lang::t('Ответить') ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="margin">
        <div class="reply-block"></div>
        <div class="comments">
            <?php foreach ($item->children as $children): ?>
                <?= $this->render('_comment', ['item' => $children]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
 