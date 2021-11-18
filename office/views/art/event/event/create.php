<?php



/* @var $this \yii\web\View */
/* @var $model \booking\forms\art\event\EventForm */
$this->title = 'Создать Событие';

$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['/art/event/event']];
$this->params['breadcrumbs'][] = 'Создать';
?>

<?= $this->render('_form', [
    'model' => $model,
    'event' => null,
]) ?>
