<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Url;


$this->registerMetaTag(['name' =>'keywords', 'content' => 'янтарь,калининград,сувениры,марципан']);
//$this->params['canonical'] = Url::to(['/shops'], true);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>

<?= $content ?>

<?php $this->endContent() ?>
