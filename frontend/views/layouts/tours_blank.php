<?php
/* @var $this \yii\web\View */

/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <div id="content">
        <?= $content ?>
    </div>
    <div class="hidden-xs">
        ВИДЖЕТ ВЫ СМОТРЕЛИ
    </div>
</div>
</div>

<?php $this->endContent() ?>
