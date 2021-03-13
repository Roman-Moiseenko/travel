<?php

use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourCommonForm;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TourCommonForm */
/* @var $tour Tour */

$this->title = 'Редактировать ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>

