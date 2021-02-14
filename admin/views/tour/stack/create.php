<?php



/* @var $this yii\web\View */
/* @var $model StackTourForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Мои Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => 'Стек туров', 'url' => ['/tour/stack']];
$this->params['breadcrumbs'][] = $this->title;

use booking\forms\booking\tours\StackTourForm; ?>

<div class="create-stack">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>