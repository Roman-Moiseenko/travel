<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SuggestWidget; ?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <div id="content">
        <?= $content ?>
    </div>
    <div class="hidden-xs">
        <?= SuggestWidget::widget() ?>
    </div>
</div>
</div>

<?php $this->endContent() ?>
