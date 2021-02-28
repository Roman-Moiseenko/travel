<?php
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\forms\office\guides\StayComfortRoomForm;
use booking\helpers\stays\ComfortHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var  $model StayComfortRoomForm */


$this->title = 'Изменить Удобство';
$this->params['breadcrumbs'][] = ['label' => 'Удобства в комнатах', 'url' => ['/guides/stay-comfort-room']];
$this->params['breadcrumbs'][] = 'Создать';


?>
<?=
$this->render('_form', [
    'model' => $model,
])
?>