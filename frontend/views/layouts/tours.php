<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;
use yii\helpers\Url;


$description = 'Обзорная, историческая экскурсия по городу Калининград, групповая и индивидуальная, экскурсии по новостройкам и курортным городам, на выездной экскурсии осмотреть замки, форты, кирхи и архитектуру немецких вилл, экскурсия на куршская коса и по изделиям из янтаря';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);

$this->registerMetaTag(['name' =>'keywords', 'content' => 'туры,экскурсия,Калининград,достопримечательности,отдых,Светлогорск,Зеленоградск,Куршская,Янтарный,замок,форт,']);
$this->params['canonical'] = Url::to(['/tours'], true);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
