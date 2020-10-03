<?php
use booking\forms\blog\TagForm;
/* @var $this yii\web\View */
/* @var $model TagForm */

$this->title = 'Создать Тег';
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
