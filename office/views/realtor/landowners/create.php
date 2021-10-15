<?php



/* @var $this \yii\web\View */
/* @var $model \booking\forms\realtor\LandownerForm */

$this->title = 'Добавить Землевладение';
$this->params['breadcrumbs'][] = ['label' => 'Землевладения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landowner-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>