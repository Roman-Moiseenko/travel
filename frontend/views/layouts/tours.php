<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;

$this->registerMetaTag(['name' =>'description', 'content' => 'Найдите на koenigs.ru уникальную авторскую экскурсию по Калининграду и забронируйте ее онлайн прямо сейчас. Максимум эмоций от наших экскурсий, минимум трудностей']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'туры,экскурсия,Калининград,достопримечательности,отдых,Светлогорск,Зеленоградск,Куршская,Янтарный']);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>
