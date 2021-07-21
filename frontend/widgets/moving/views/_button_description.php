<?php


use booking\entities\moving\Page;
use booking\helpers\SysHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $category Page */

?>
<h2><?= $category->title ?></h2>
<p style="text-align: justify; text-indent: 40px; font-size: 16px; line-height: 2.5rem; padding-top: 12px">
    <?= $category->description ?>
</p>
<p style="font-size: 16px; line-height: 2.5rem; padding-top: 12px">
    <a href="<?= Url::to(['/moving/moving/view', 'slug' => $category->slug])?>"><i class="fab fa-readme"></i>&#160;<?= $category->name ?></a>
</p>