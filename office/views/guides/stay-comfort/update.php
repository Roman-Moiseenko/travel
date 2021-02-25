<?php
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\helpers\stays\ComfortHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $model StayComfortForm */


$this->title = 'Изменить Удобство';
$this->params['breadcrumbs'][] = ['label' => 'Общие Удобства', 'url' => ['/guides/stay-comfort']];
$this->params['breadcrumbs'][] = 'Создать';


?>
<?=
$this->render('_form', [
    'model' => $model,
])
?>