<?php

use booking\entities\booking\trips\placement\Placement;
use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\PlacementForm;

/* @var $this \yii\web\View */
/* @var $model PlacementForm */
/* @var $trip Trip */
/* @var $placement Placement */

$this->title = 'Редактировать место проживания';
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Проживание', 'url' => ['/trip/placement/index', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => $placement->name, 'url' => ['/trip/placement/view', 'id' => $placement->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

?>

<div class="tour-create">

    <?= $this->render('_form', [
        'model' => $model,
    ])?>

</div>