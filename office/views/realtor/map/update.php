<?php


/* @var $this yii\web\View */

use booking\entities\realtor\land\Land;
use booking\forms\land\LandForm;
use office\assets\LandAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $land Land */
/* @var $model LandForm */

$this->title = 'Редактировать участок';
$this->params['breadcrumbs'][] = ['label' => 'Земельные участки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $land->name;
LandAsset::register($this);
?>

<div>
    <div id="map-land-edit" style="width: 100%; height: 700px;"></div>
</div>
