<?php

use booking\forms\booking\tours\TourCommonForm;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TourCommonForm */

$this->title = 'Создать Тур';
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-create">

<?=
$this->render('_form', [
        'model' => $model,
])
?>

</div>

