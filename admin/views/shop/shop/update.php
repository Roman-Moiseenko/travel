<?php

use booking\entities\booking\tours\Tour;
use booking\entities\shops\Shop;
use booking\forms\booking\tours\TourCommonForm;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ShopCreateForm */
/* @var $shop Shop */

$this->title = 'Редактировать ' . $shop->name;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-update">

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>

