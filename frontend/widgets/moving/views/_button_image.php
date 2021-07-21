<?php


use booking\entities\moving\Page;
use booking\helpers\SysHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $category Page */
?>

<div class="item-responsive item-0-67by1">
    <div class="content-item">
        <a href="<?= Url::to(['/moving/moving/view', 'slug' => $category->slug])?>">
        <img style="border-radius: 25px; " alt="<?= $category->title?>" loading="lazy" src="<?= $category->getThumbFileUrl('photo', 'button_image')?>" width="100%" />
            <div class="card-img-overlay  d-flex flex-column">
                <div class="mt-auto"><h3 class="card-title" style="color: white; text-shadow: black 2px 2px 1px"><?= $category->name?></h3></div>
            </div>
        </a>
    </div>
</div>