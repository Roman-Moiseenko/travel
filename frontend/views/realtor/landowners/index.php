<?php

use booking\entities\realtor\Landowner;
use frontend\widgets\info\InfoLandownersWidget;use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $landowners Landowner */

$this->title = 'Земельные участи под ИЖС в Калининградской области';
$description = 'Земельные участи под ИЖС в Калининградской области по низким ценам от собственников, возможно строительство домов и сопровождение';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->params['canonical'] = Url::to(['/realtor/landowners'], true);
$this->params['breadcrumbs'][] = ['label' => 'Агентство', 'url' => Url::to(['/realtor'])];
$this->params['breadcrumbs'][] = 'Участки';

?>

<div>
    <h1 class="pb-4">Земельные участки под ИЖС на продажу</h1>
    <?= $this->render('_list', ['landowners' => $landowners]) ?>
    <?= InfoLandownersWidget::widget() ?>
</div>
