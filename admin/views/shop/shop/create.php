<?php

use booking\forms\booking\tours\TourCommonForm;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ShopCreateForm */

$this->title = 'Создать Магазин (Онлайн)';
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-create">



    <?= $this->render('_form', [
        'model' => $model,
    ])?>


</div>

