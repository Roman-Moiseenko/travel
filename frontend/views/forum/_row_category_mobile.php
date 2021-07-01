<?php

use booking\helpers\UserForumHelper;
use yii\helpers\Url; ?>

<tr class="row_link" onclick="window.location.href='<?= Url::to(['forum/category', 'id' => $category->id])?>'; return false">
    <td class="col_img">
        <?= UserForumHelper::isReadCategory($category->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
    </td>
    <td class="col_forum_mobile">
        <h3 class="row_name"><?= $category->name ?></h3>
        <div class="row_description">
            <?= $category->description ?>
        </div>
        <div>
            Темы: <?= $category->countPost() . ' <i class="fas fa-folder-open"></i>' ?> Посты: <?= $category->count . ' <i class="fas fa-envelope-open-text"></i>' ?>
        </div>
    </td>
</tr>
