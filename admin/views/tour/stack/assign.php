<?php

use booking\entities\booking\tours\stack\Stack;
use booking\entities\booking\tours\Tour;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $stack Stack */
/* @var $tours Tour[] */

/* @var $searchModel admin\forms\tours\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.assign-check', function () {
        let tour_id = $(this).attr('tour-id');
        let stack_id = $(this).attr('stack-id');
        let value = 0;
        if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post("/tour/stack/set-stack",
            {tour_id: tour_id, stack_id: stack_id, set: value},
            function (data) {
            console.log(data);
        });
    });
});
JS;
$this->registerJs($js);
$this->title = 'Экскурсии';
$this->params['breadcrumbs'][] = ['label' => 'Мои Экскурсии', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => 'Стек Экскурсий', 'url' => ['/tour/stack']];
$this->params['breadcrumbs'][] = ['label' => $stack->name, 'url' => ['/tour/stack/view', 'id' => $stack->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-secondary">
    <div class="card-header">Экскурсии в стеке</div>
    <div class="card-body">
        <table class="table table-adaptive table-striped table-bordered">
            <?php foreach ($tours as $tour): ?>
            <tr>
                <td data-label="Применить" width="20px">
                    <input type="checkbox" class="assign-check" tour-id="<?=$tour->id ?>" stack-id="<?=$stack->id ?>" <?= $stack->isFor($tour->id) ? 'checked' : '' ?>>
                </td>
                    <td data-label="Экскурсия">
                        <?= $tour->name ?>
                    </td>
                <td data-label="ID">
                    <?= $tour->id ?>
                </td>

            </tr>
            <?php endforeach; ?>
        </table>

    </div>
</div>