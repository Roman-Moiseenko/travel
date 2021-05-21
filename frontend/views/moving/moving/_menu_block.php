<?php
/* @var $image string*/
/* @var $caption string*/
/* @var $text string*/
/* @var $link string*/

?>
<div class="card">
    <div class="card-img-top">
        <div class="item-responsive item-2-0by3">
            <div class="content-item">
                <img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/moving/' . $image ?>"
                     alt="<?= $caption ?>" class="card-img-top" loading="lazy">
            </div>
        </div>
    </div>
    <div class="card-body">
        <h2 style="font-size: 15px;"><?= $caption ?></h2>
        <?= $text ?>
    </div>
    <a href="<?= $link ?>" class="stretched-link">Читать далее ...</a>
</div>