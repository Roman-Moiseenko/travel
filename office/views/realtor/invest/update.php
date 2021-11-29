<?php



/* @var $this \yii\web\View */
/* @var $model \booking\forms\realtor\land\LandForm */
/* @var $land \booking\entities\realtor\land\Land */
$this->title = 'Редактировать ' . $land->name;
$this->params['breadcrumbs'][] = ['label' => 'Инвестиционные участки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $land->name, 'url' => ['view', 'id' => $land->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<?= $this->render('_form', [
    'model' => $model,
    'land' => $land,
]) ?>