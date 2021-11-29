<?php


use booking\entities\moving\Page;
use booking\helpers\SysHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $category Page */
/* @var $section string */
?>
<h2><?= $category->title ?></h2>
<div class="moving-button-text pt-3">
    <?= $category->description ?>
</div>
<p style="font-size: 16px; line-height: 2.5rem; padding-top: 12px">
    <a href="<?= Url::to([$section . '/view', 'slug' => $category->slug])?>"><i class="fab fa-readme"></i>&#160;<?= $category->name ?></a>
</p>