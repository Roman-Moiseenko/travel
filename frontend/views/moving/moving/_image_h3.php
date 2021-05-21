<?php
 /* @var $image_file string */
 /* @var $alt string */
?>

<div class="item-responsive item-2-0by1">
    <div class="content-item">
        <img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/moving/' . $image_file ?>"
             alt="<?= $alt ?>" title="<?= $alt ?>"
             width="50%" loading="lazy">
    </div>
</div>
