<?php
/* @var $this \yii\web\View */

/* @var $content string */


$this->registerMetaTag(['name' =>'description', 'content' => 'Найдите на koenigs.ru квартиру апартаменты или дом для снятия целиком недорого в Калининграде и области низкая цена при бронировании']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'квартиры,посуточно,аренда,жилья,Калининград,отдых']);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>

