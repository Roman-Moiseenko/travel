<?php

use booking\entities\realtor\Landowner;
use frontend\widgets\info\InfoLandownersWidget;use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $landowners Landowner */

$this->title = 'Купить земельный участок под ИЖС в Калининграде и Калининградской области';
$description = 'Земельные участи под ИЖС в Калининградской области по низким ценам от собственников, возможно строительство домов и сопровождение';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->params['canonical'] = Url::to(['/realtor/landowners'], true);
$this->params['breadcrumbs'][] = ['label' => 'Земля', 'url' => Url::to(['/realtor'])];
$this->params['breadcrumbs'][] = 'Под ИЖС';

?>

<div>
    <h1 class="pb-4">Лучшие земельные участки под ИЖС в Калининградской области</h1>
    <?php foreach ($landowners as $landowner): ?>
        <?= $this->render('_landowner', [
            'landowner' => $landowner
        ]) ?>
    <?php endforeach; ?>
    <?= InfoLandownersWidget::widget() ?>
</div>
