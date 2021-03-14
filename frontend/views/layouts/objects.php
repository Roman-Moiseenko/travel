<?php


use frontend\widgets\BlogViewerWidget;
use frontend\widgets\SearchToursWidget;
/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<div class="hidden-xs">
    <?= BlogViewerWidget::widget() ?>
</div>
<?php $this->endContent() ?>
