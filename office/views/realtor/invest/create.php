<?php



/* @var $this \yii\web\View */
/* @var $model \booking\forms\realtor\land\LandForm */
$this->title = 'Создать Инвестиционный участок';
$this->params['breadcrumbs'][] = ['label' => 'Инвестиционные участки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создать';
?>

<?= $this->render('_form', [
    'model' => $model,
    'land' => null,
]) ?>
