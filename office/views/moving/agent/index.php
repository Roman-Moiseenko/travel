<?php

use booking\entities\moving\agent\Region;
use office\forms\moving\RegionSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


/* @var $this View */
/* @var $searchModel RegionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Регионы представителей Агентства на ПМЖ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="providers-list">
    <p>
        <?= Html::a('Создать Регион', ['create-region'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card card-secondary">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-adaptive table-striped table-bordered',
                ],
                'columns' => [
                    [
                        'attribute' => 'id',
                        'options' => ['width' => '20px',],
                        'contentOptions' => ['data-label' => 'ID'],
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (Region $model) {
                            return Html::a($model->name, ['moving/agent/view-region', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Регион',
                        'contentOptions' => ['data-label' => 'Регион'],
                    ],
                    [
                        'attribute' => 'link',
                        'value' => function (Region $model) {
                            return Html::a($model->link, $model->link);
                        },
                        'format' => 'raw',
                        'label' => 'Ссылка на форум',
                        'contentOptions' => ['data-label' => 'Ссылка на форум'],
                    ],
                    [
                        'value' => function (Region $model) {
                            return count($model->agents) . ' представителей';
                        },
                        'format' => 'raw',
                        'label' => 'Представители',
                        'contentOptions' => ['data-label' => 'Представители'],
                    ],
                    [
                        'value' => function (Region $model) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up-region', 'id' => $model->id],
                                    ['data-method' => 'post',]) .
                                Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down-region', 'id' => $model->id],
                                    ['data-method' => 'post',]);
                        },
                        'format' => 'raw',
                        'label' => 'Сортировка',
                        'contentOptions' => ['data-label' => 'Сортировка'],
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>


