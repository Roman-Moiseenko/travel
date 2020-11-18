<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
?>
<div class="content">
    <!-- Content Header (Page header) -->
    <?= \frontend\widgets\AlertWidget::widget() ?>
        <?= $content ?>
</div>