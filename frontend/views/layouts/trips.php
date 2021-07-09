<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Url;


$description = 'Лечебные, оздоровительные туры в Калининград и Калининградскую область, туры по янтарю, исторические туры, для двоих, семейные и для отдыха';
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
