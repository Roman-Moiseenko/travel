<?php

/* @var $this \yii\web\View */
/* @var $content string */

use booking\entities\Lang;
use frontend\widgets\TopmenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
?>
<?php $this->beginPage() ?>
<?php $this->beginBody() ?>
        <?= $content ?>
    <?php $this->endBody() ?>
<?php $this->endPage() ?>