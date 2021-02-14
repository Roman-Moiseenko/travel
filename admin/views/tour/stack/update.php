<?php

use booking\entities\booking\tours\stack\Stack;
use booking\forms\booking\tours\StackTourForm;

/* @var $this yii\web\View */
/* @var $model StackTourForm */
/* @var  $stack Stack */

$this->title = 'Изменить ' . $stack->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => 'Стек туров', 'url' => ['/tour/stack']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="update-stack">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>