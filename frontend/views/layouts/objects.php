<?php


use booking\helpers\SysHelper;
use frontend\widgets\BlogViewerWidget;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<div class="hidden-xs pt-5">
    <?= BlogViewerWidget::widget([
            'mobile' => SysHelper::isMobile(),
    ]) ?>
</div>
<?php $this->endContent() ?>
