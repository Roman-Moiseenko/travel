<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;
$this->registerMetaTag(['name' =>'description', 'content' => 'Найдите на koenigs.ru авто, вело, мото, водный транспорт по своему характеру в Калининграде, и возьмите в прокат его прямо сейчас']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'прокат,аренда,автомобили,велосипеды,скутеры,Калининград,Светлогорск,Зеленоградск,Куршская,Янтарный']);

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>
