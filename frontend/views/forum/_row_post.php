<?php

use booking\helpers\UserForumHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<tr class="row_link">
    <?php if ($user && $user->preferences->isForumUpdate()): ?>
        <td class="col_admin">
            <?php if ($post->isFix()): ?>
                <a href="<?= Url::to(['forum/unfix-post', 'id' => $post->id]) ?>"><i
                        class="fas fa-check-double"></i></a>
            <?php else: ?>
                <a href="<?= Url::to(['forum/fix-post', 'id' => $post->id]) ?>"><i
                        class="fas fa-check"></i></a>
            <?php endif; ?>
            <?php if ($user->preferences->isForumAdmin()): ?>
                <a href="<?= Url::to(['forum/remove-post', 'id' => $post->id]) ?>"
                   data-confirm="Удалить данную тему?" data-method="post"><i
                        class="fas fa-times"></i></a>
            <?php endif; ?>
            <?php if ($post->isActive()): ?>
                <a href="<?= Url::to(['forum/lock-post', 'id' => $post->id]) ?>"><i
                        class="fas fa-lock"></i></a>
            <?php else: ?>
                <a href="<?= Url::to(['forum/unlock-post', 'id' => $post->id]) ?>"><i
                        class="fas fa-lock-open"></i></a>
            <?php endif; ?>
        </td>
    <?php endif; ?>

    <td class="col_img_mini <?= $post->isFix() ? 'col_fix' : '' ?>"
        onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id]) ?>'; return false">
        <?= UserForumHelper::isReadPost($post->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
    </td>
    <td class="col_forum"
        onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id]) ?>'; return false">
        <div class="row_post">
            <?= $post->isActive() ? '' : '<i class="fas fa-lock"></i> ' ?>
            <h2 class="row_post"><?= $post->caption ?></h2>
        </div>
    </td>
    <td class="col_stat"
        onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id]) ?>'; return false">
        <div><?= $post->count() . ' <i class="fas fa-envelope-open-text"></i>' ?></div>
    </td>
    <td class="col_post"
        onclick="window.location.href='<?= Url::to(['forum/post', 'id' => $post->id]) ?>'; return false">
        <span class="row_description"><?= $post->lastMessage->userName(true) . ' от ' . date('Y-m-d H:i', $post->lastMessage->lastDate()) ?></span>
    </td>
</tr>