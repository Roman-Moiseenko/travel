<?php
/* @var $this \yii\web\View */

/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>

<div class="row">
    <!-- -->
    <div id="content" class="col-sm-3">
        <!-- ПОИСК -->
        ВИДЖЕТ Расширенного ПОИСКА
        ВИДЖЕТ Поиска по характеристикам
    </div>
    <div id="content" class="col-sm-9">
        <?= $content ?>
    </div>
    </div>
</div>

<?php $this->endContent() ?>

