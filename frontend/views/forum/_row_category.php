<?php

use booking\helpers\UserForumHelper;
use yii\helpers\Url; ?>

<tr class="row_link" onclick="window.location.href='<?= Url::to(['forum/category', 'id' => $category->id])?>'; return false">
    <td class="col_img">
        <?= UserForumHelper::isReadCategory($category->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
    </td>
    <td class="col_forum">
        <h3 class="row_name"><?= $category->name ?></h3>
        <span class="row_description">
                            <?= $category->description ?>
                        </span>
    </td>
    <td class="col_stat">
        <div><?= $category->countPost() . ' <i class="fas fa-folder-open"></i>' ?></div>
        <div><?= $category->countMessage() . ' <i class="fas fa-envelope-open-text"></i>' ?></div>
    </td>
    <td class="col_post">
        <?php if ($category->lastMessage): ?>
            <div class="row_last_post"><?= $category->lastMessage->caption() ?></div>
            <span class="row_last_message"><?= $category->lastMessage->userName(true) . ' от ' . $category->lastMessage->date() ?></span>
        <?php endif;  ?>
    </td>
</tr>
