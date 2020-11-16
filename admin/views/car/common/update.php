<?php

use booking\entities\booking\cars\Car;
use booking\forms\booking\cars\CarCommonForm;
use booking\helpers\cars\CarTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CarCommonForm */
/* @var $car Car */

$this->title = 'Редактировать ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

