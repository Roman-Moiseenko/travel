<?php
/* @var $this yii\web\View */
/* @var $searchModel office\forms\guides\NearbyCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории окрестностей';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\entities\booking\stays\Type;
use booking\helpers\stays\ComfortHelper;
use office\forms\guides\NearbyCategorySearch;
use yii\grid\GridView;use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="providers-list">
    <p>

        <?= Html::a('Создать Категорию окрестности', ['create'], ['class' => 'btn btn-success']) ?>

    </p>
    <div class="card">
        <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-adaptive table-striped table-bordered',],

            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['width' => '20px',],
                    'contentOptions' => ['data-label' => 'ID'],
                ],
                [
                    'attribute' => 'group',
                    'value' => function (NearbyCategory $model) {
                        return NearbyCategory::listGroup()[$model->group];
                    },
                    'label' => 'Группировка',
                    'filter' => NearbyCategory::listGroup(),
                    'contentOptions' => ['data-label' => 'Группировка'],
                ],
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                    'contentOptions' => ['data-label' => 'Название'],
                ],
                [
                    'label' => 'Сортировка',
                    'contentOptions' => ['data-label' => 'Сортировка'],
                    'format' => 'raw',
                    'value' => function (NearbyCategory $model) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id],
                                ['data-method' => 'post',]) .
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id],
                                ['data-method' => 'post',]);
                    }

                ],
                ['class' => 'yii\grid\ActionColumn',],
            ],
    ]) ?>
        </div>
    </div>
</div>