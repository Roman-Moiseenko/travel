<?php

/* @var $this \yii\web\View */
/* @var $content string */

use booking\entities\Lang;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=f2af7b42-59f9-44b0-a60b-38c7d431e657&lang=ru_RU" type="text/javascript">
    </script>
</head>
<body>
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

