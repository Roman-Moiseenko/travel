<?php
/* @var $this \yii\web\View */

/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <!-- -->
    <div id="content" class="col-sm-3">
        <!-- ПОИСК -->
        ВИДЖЕТ Расширенного ПОИСКА Тура
        ВИДЖЕТ Поиска по характеристикам
    </div>
    <div id="content" class="col-sm-9">
        <?= $content ?>
    </div>
    <div class="hidden-xs">
        ВИДЖЕТ ВЫ СМОТРЕЛИ
    </div>
</div>
</div>

<?php $this->endContent() ?>
