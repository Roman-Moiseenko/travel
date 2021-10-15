<?php

use booking\entities\realtor\Landowner;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \booking\forms\realtor\LandownerForm */
/* @var $landowner Landowner */

$this->title = 'Редактировать Землевладение: ' . $landowner->name;
$this->params['breadcrumbs'][] = ['label' => 'Землевладения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $landowner->name, 'url' => ['view', 'id' => $landowner->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="landowner-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
