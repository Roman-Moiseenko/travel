<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;

$this->registerMetaTag(['name' =>'keywords', 'content' => 'где поесть,ресторан,Калининград,кафе,кухня,пить кофе,деликатесы']);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
