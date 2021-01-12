<?php

/* @var $categories Category[] */

use booking\entities\forum\Category;
use booking\helpers\ForumHelper;
use yii\helpers\Url;

$this->title = 'Форум провайдеров';
$this->params['breadcrumbs'][] = $this->title;
?>
В разработке ....
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <tbody>
            <?php foreach ($categories as $category): ?>
                <tr class="row_link" onclick="window.location.href='<?= Url::to(['forum/category', 'id' => $category->id])?>'; return false">
                    <td class="col_img">
                        <?= ForumHelper::isReadCategory($category->id) ? '<i class="far fa-envelope-open"></i>' : '<i class="fas fa-envelope"></i>' ?>
                    </td>
                    <td class="col_forum">
                        <div class="row_name">
                            <?= $category->name ?>
                        </div>
                        <span class="row_description">
                            <?= $category->description ?>
                        </span>
                    </td>
                    <td class="col_stat">
                        <div><?= $category->countPost() . ' тем' ?></div>
                        <div><?= $category->count . ' сообщений' ?></div>
                    </td>
                    <td class="col_post">
                        <?php if ($category->lastMessage): ?>
                            <div class="row_post"><?= $category->lastMessage->post->caption ?></div>
                            <span class="row_description"><?= 'Сообщение ' . $category->lastMessage->user->username . ' от ' . date('Y-m-d', $category->lastMessage->created_at) ?></span>
                        <?php endif;  ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>