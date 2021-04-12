<?php

use booking\entities\blog\map\Maps;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $map Maps */

$this->title = $map->name;
$this->params['breadcrumbs'][] = ['label' => 'Карты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $map->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $map->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить Карту?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $map,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'format' => 'text',
                        'label' => 'Название'
                    ],
                    [
                        'attribute' => 'slug',
                        'format' => 'text',
                        'label' => 'Ссылка'
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <p>
        <?= Html::a('Добавить точку', ['add-point', 'id' => $map->id], ['class' => 'btn btn-info']) ?>
    </p>
    <div class="card">
        <div class="card-header with-border">Точки</div>
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
            <?php foreach ($map->points as $point): ?>
                <tr>
                    <td data-label="ID" width="20px"><?= $point->id ?></td>
                    <td data-label="Фото" width="110px"><img src="<?= $point->getThumbFileUrl('photo', 'admin') ?>"></td>
                    <td data-label="Загаловок"><?= $point->caption ?></td>
                    <td data-label="Ссылка"><?= $point->link ?></td>
                    <td width="80px">
                        <a href="<?= Url::to(['update-point', 'id' => $point->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-point', 'id' => $point->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Точку?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
        </div>
    </div>
    <p>
        <?= Html::a('Добавить точку', ['add-point', 'id' => $map->id], ['class' => 'btn btn-info']) ?>
    </p>

</div>
