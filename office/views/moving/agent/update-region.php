<?php

use booking\entities\moving\agent\Region;
use booking\forms\moving\RegionForm;
use yii\web\View;

/* @var $this View */
/* @var $model RegionForm */
/* @var $region Region */
$this->title = 'Редактировать Регион ' . $region->name;
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $region->name, 'url' => ['view-region', 'id' => $region->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="region-create">

    <?= $this->render('_form_region', [
        'model' => $model,
    ]) ?>

</div>
