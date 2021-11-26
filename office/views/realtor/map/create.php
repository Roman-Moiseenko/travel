<?php


use booking\forms\realtor\land\LandForm;
use office\assets\LandAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model LandForm */

$this->title = 'Создать участок';
$this->params['breadcrumbs'][] = ['label' => 'Земельные участки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
LandAsset::register($this);
?>
<?= $this->render('_form', [
    'model' => $model,
    'land' => null,

]) ?>