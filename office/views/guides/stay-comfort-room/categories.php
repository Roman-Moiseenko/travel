<?php
/* @var $this yii\web\View */
/* @var $searchModel office\forms\guides\StayComfortRoomCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории удобств';
$this->params['breadcrumbs'][] = ['label' => 'Удобства в комнатах', 'url' => ['/guides/stay-comfort-room']];
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use booking\entities\booking\stays\Type;
use yii\grid\GridView;use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="providers-list">
    <p>
        <?= Html::a('Создать Категорию Удобств', ['create-category'], ['class' => 'btn btn-success']) ?>
    </p>
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
                    'label' => 'Название',
                    'contentOptions' => ['data-label' => 'Название'],
                ],
                [
                    'attribute' => 'image',
                    'label' => 'Картинка',
                    'format' => 'raw',
                    'value' => function (ComfortRoomCategory $model) {
                        return '<i class="' . $model->image . '"></i>';
                    },
                    'contentOptions' => ['data-label' => 'Картинка'],
                ],
                [
                    'label' => 'Сортировка',
                    'contentOptions' => ['data-label' => 'Сортировка'],
                    'format' => 'raw',
                    'value' => function (ComfortRoomCategory $model) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up-category', 'id' => $model->id],
                                ['data-method' => 'post',]) .
                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down-category', 'id' => $model->id],
                                ['data-method' => 'post',]);
                    }

                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, ComfortRoomCategory $model, $key) {

                                $url = Url::to(['update-category', 'id' => $model->id]);
                                $icon = Html::tag('i', '', ['class' => "glyphicon glyphicon-pencil"]);
                                return Html::a($icon, $url);

                        },
                        'delete' => function ($url, ComfortRoomCategory $model, $key) {

                                $url = Url::to(['delete-category', 'id' => $model->id]);
                                $icon = Html::tag('i', '', ['class' => "glyphicon glyphicon-trash"]);
                                return Html::a($icon, $url, [
                                    'title' => 'Удалить',
                                    'aria-label' => 'Удалить',
                                    'data-pjax' => 0,
                                    'data-confirm' => 'Вы уверены, что хотите Удалить ' . $model->name . '?',
                                    'data-method' => 'post',
                                ]);

                        },
                    ],
                    ],
            ],

    ]) ?>
</div>