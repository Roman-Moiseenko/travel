<?php

use booking\forms\moving\RegionForm;
use yii\web\View;

/* @var $this View */
/* @var $model RegionForm */

$this->title = 'Создать Регион';
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="region-create">

    <?= $this->render('_form_region', [
        'model' => $model,
    ]) ?>

</div>
