<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget; ?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <!-- ПОИСК -->

<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>
    <div class="hidden-xs">
        ВИДЖЕТ ВЫ СМОТРЕЛИ
    </div>
</div>

<?php $this->endContent() ?>
