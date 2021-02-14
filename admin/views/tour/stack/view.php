<?php

use booking\entities\booking\tours\stack\Stack;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $stack Stack */
$this->title = $stack->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => 'Стек туров', 'url' => ['/tour/stack']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Изменить параметры', Url::to(['/tour/stack/update', 'id' => $stack->id]), ['class' => 'btn btn-success']) ?>
    <?= Html::a('Изменить стек', Url::to(['/tour/stack/assign', 'id' => $stack->id]), ['class' => 'btn btn-info']) ?>
</p>
<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $stack,
            'attributes' => [
                [
                    'attribute' => 'count',
                    'label' => 'Кол-во экскурсий в день'
                ],
                [
                    'attribute' => 'legal_id',
                    'value' => $stack->legal->caption,
                    'label' => 'Организация',
                ],
            ],
        ]); ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">Экскурсии в стеке</div>
    <div class="card-body">
        <table class="table table-adaptive table-striped table-bordered">
        <?php foreach ($stack->tours as $tour): ?>
        <tr>
        <td><?= $tour->name ?></td>
        </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>