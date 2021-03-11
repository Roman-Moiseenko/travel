<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;

$this->registerMetaTag(['name' =>'description', 'content' => 'Обзорная, историческая экскурсия по Калининграду, групповая и индивидуальная, экскурсии по новостройкам и курортным городам, осмотреть замки, форты, кирхи и немецкие виллы, изделиям из янтаря']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'туры,экскурсия,Калининград,достопримечательности,отдых,Светлогорск,Зеленоградск,Куршская,Янтарный']);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>
