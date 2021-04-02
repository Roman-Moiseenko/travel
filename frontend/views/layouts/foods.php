<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;
use yii\helpers\Url;

//$this->registerMetaTag(['name' =>'description', 'content' => 'Обзорная, историческая экскурсия по городу Калининград, групповая и индивидуальная, экскурсии по новостройкам и курортным городам, на выездной экскурсии осмотреть замки, форты, кирхи и архитектуру немецких вилл, экскурсия на куршская коса и по изделиям из янтаря']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'где поесть,ресторан,Калининград,кафе,кухня,пить кофе,деликатесы']);

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
