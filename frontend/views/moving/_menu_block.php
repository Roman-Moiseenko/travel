<?php
/* @var $image string*/
/* @var $caption string*/
/* @var $text string*/
/* @var $link string*/

?>
<div class="card">
    <div class="card-img-top">
        <img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/moving/' . $image ?>"  alt="Пакет документов для переезда">
    </div>
    <div class="card-body">
        <h4><?= $caption ?></h4>
        <?= $text ?>
    </div>
    <a href="<?= $link ?>" class="stretched-link">Читать далее ...</a>
</div>