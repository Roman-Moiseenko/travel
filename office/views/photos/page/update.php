<?php



/* @var $this \yii\web\View */
/* @var $model \booking\forms\photos\PageForm */
/* @var $page \booking\entities\photos\Page */
$this->title = 'Изменить Публикацию ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Публикации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>