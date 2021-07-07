<?php

use booking\entities\booking\trips\placement\Placement;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $trip \booking\entities\booking\trips\Trip|null */
/* @var $placements Placement[] */
$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.placement-assign', function () {
        //alert('t');
        let trip_id = $(this).attr('trip-id');
        let placement_id = $(this).attr('placement-id');
        let value = 0;
         if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post("/trip/placement/assign?id="+trip_id+"&placement_id="+placement_id+"&set="+value,
            {},
            function (data) {
            location.reload();
        });
    });
});
JS;
$this->registerJs($js);

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
        <table class="table table-striped table-adaptive w-75">
        <?php foreach ($trip->placements as $placement):?>
            <tr>
                <td width="60px">
                    <input type="checkbox" class="placement-assign" trip-id="<?= $trip->id?>" placement-id="<?= $placement->id?>" checked>
                </td>
                <td>
                    <a href="<?= Url::to(['/trip/placement/view', 'id'=> $trip->id, 'placement_id' => $placement->id])?>"><?= $placement->name ?></a><br>
                </td>
            </tr>
        <?php endforeach;?>
        </table>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header with-border">Стек объектов проживания</div>
    <div class="card-body">
        <table class="table table-striped table-adaptive w-75">
        <?php foreach ($placements as $placement):?>
         <?php if (!$trip->isPlacementAssign($placement->id)): ?>
            <tr>
                <td width="60px">
                    <input type="checkbox" class="placement-assign" trip-id="<?= $trip->id?>" placement-id="<?= $placement->id?>">
                </td>
                <td>
                <a href="<?= Url::to(['/trip/placement/view', 'id'=> $trip->id, 'placement_id' => $placement->id])?>"><?= $placement->name ?></a><br>
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach;?>
        </table>
    </div>
</div>

<?php if ($trip->filling) {
    echo Html::a('Далее >>', Url::to(['filling', 'id' => $trip->id]), ['class' => 'btn btn-primary']);
}
?>