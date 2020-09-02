<?php

/* @var $this yii\web\View */

use booking\entities\booking\tours\Tour;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var  $tour Tour*/
/* @var $dataProvider \yii\data\DataProviderInterface */

$this->title = 'Отчеты по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tours/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Отчеты';
?>
<div class="tour-report">

</div>
