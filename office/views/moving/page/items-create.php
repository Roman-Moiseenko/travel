<?php



/* @var $this \yii\web\View */
/* @var $page \booking\entities\moving\Page|null */
/* @var $model \booking\forms\moving\ItemForm */

$this->title = 'Создать Элемент - ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['moving/page/view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = ['label' => 'Список', 'url' => ['moving/page/items', 'id' => $page->id]];
$this->params['breadcrumbs'][] = 'Создать';
?>

<div class="items-create">

    <?= $this->render('items-form', [
        'model' => $model,
        'item' => null,
        'page' => $page,
    ]) ?>
</div>