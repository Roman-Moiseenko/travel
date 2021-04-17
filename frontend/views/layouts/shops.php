<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;
use frontend\widgets\shop\CategoriesWidget;
use yii\helpers\Url;


$description = 'Что привезти из Калининграда сувениры из янтаря, ручная работа на память марципан картины, янтарная косметика, балтийский песок';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);

$this->registerMetaTag(['name' =>'keywords', 'content' => 'янтарь,калининград,сувениры,марципан']);
$this->params['canonical'] = Url::to(['/shops'], true);
?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>

<?= $content ?>

<?php $this->endContent() ?>
