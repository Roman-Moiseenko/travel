<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
$this->title = 'Операции с землей в Калининграде - купля-продажа, инвестиции';
$this->registerMetaTag(['name' => 'description', 'content' => 'Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки,']);

$this->params['canonical'] = Url::to(['/land/map'], true);
$this->params['breadcrumbs'][] = ['label' => 'Агентство', 'url' => Url::to(['/lands'])];

$this->params['breadcrumbs'][] = 'Еще один раздел';
LandAsset::register($this);



?>
<h1>Еще один раздел</h1>