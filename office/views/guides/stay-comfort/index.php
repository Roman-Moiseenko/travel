<?php
/* @var $this yii\web\View */
/* @var $searchModel office\forms\guides\StayComfortSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Общие удобства';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\Type;
use booking\helpers\stays\ComfortHelper;
use yii\grid\GridView;use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="providers-list">
    <p>

        <?= Html::a('Создать Удобство', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Категории Удобств', ['categories'], ['class' => 'btn btn-info']) ?>
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
                    'attribute' => 'category_id',

                    'value' => function (Comfort $model) {
                        return $model->category->name;
                    },
                    'filter' => ComfortHelper::listCategories(),
                    'label' => 'Категория',
                    'contentOptions' => ['data-label' => 'Категория'],
                ],
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                    'value' => function (Comfort $model) {
                        return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
                    },
                    'format' => 'raw',
                    'contentOptions' => ['data-label' => 'Название'],
                ],
                [
                    'attribute' => 'paid',
                    'label' => 'Возможность оплаты',
                    'value' => function (Comfort $model) {
                        return $model->paid ? 'Есть' : 'Нет';
                    },
                    'contentOptions' => ['data-label' => 'Возможность оплаты'],
                ],
                [
                    'attribute' => 'featured',
                    'label' => 'Рекомендуем',
                    'value' => function (Comfort $model) {
                        return $model->featured ? 'Да' : 'Нет';
                    },
                    'filter' => [false => 'Нет', true => 'Да'],
                    'contentOptions' => ['data-label' => 'Рекомендуем'],
                ],
                [
                    'attribute' => 'photo',
                    'label' => 'Фото',
                    'value' => function (Comfort $model) {
                        return $model->photo ? 'Да' : 'Нет';
                    },
                    'contentOptions' => ['data-label' => 'Фото'],
                ],
                ['class' => 'yii\grid\ActionColumn',],
            ],
    ]) ?>
        </div>
    </div>
</div>