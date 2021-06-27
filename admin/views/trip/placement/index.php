<?php

use booking\entities\booking\trips\placement\Placement;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $trip \booking\entities\booking\trips\Trip|null */
/* @var $placements Placement[] */

$this->title = 'Проживание ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Проживание';


  ?>

<p>
    <?= Html::a('Создать место проживания', Url::to(['trip/placement/create', 'id' => $trip->id]), ['class' => 'btn btn-success']) ?>
</p>
<div class="card card-secondary">
    <div class="card-header with-border">Выбранные места проживания</div>
    <div class="card-body">
        <?php foreach ($trip->placements as $placement):?>

        <?php endforeach;?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header with-border">Стек объектов проживания</div>
    <div class="card-body">
        <?php foreach ($placements as $placement):?>
         <?php if (!$trip->isPlacementAssign($placement->id)): ?>
                <a href="<?= Url::to(['/trip/placement/view', 'id'=> $trip->id, 'placement_id' => $placement->id])?>"><?= $placement->name ?></a><br>
        <?php endif; ?>
        <?php endforeach;?>
    </div>
</div>

<?php if ($trip->filling) {
    echo Html::a('Далее >>', Url::to(['filling', 'id' => $trip->id]), ['class' => 'btn btn-primary']);
}
?>