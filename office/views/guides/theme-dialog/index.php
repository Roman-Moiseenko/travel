<?php
/* @var $this yii\web\View */
/* @var $themes ThemeDialog[] */
/* @var $this yii\web\View */
/* @var $searchModel office\forms\ToursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Темы диалогов';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\helpers\DialogHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="theme-dialog">
    <p>
        <?= Html::a('Создать Тему', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card" style="width: 70% !important;">
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
                        'attribute' => 'caption',
                        'label' => 'Заголовок',
                        'contentOptions' => ['data-label' => 'Заголовок'],
                    ],
                    [
                        'attribute' => 'type_dialog',
                        'filter' => DialogHelper::getTypeList(),
                        'value' => function (ThemeDialog $model) {
                            return $model->type_dialog == 0 ? '' : DialogHelper::getTypeList()[$model->type_dialog];
                        },
                        'format' => 'raw',
                        'label' => 'Тип диалога',
                        'contentOptions' => ['data-label' => 'Тип диалога'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, ThemeDialog $model, $key) {
                                if ($model->id > 99) {
                                    $url = Url::to(['update', 'id' => $model->id]);
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                                    return Html::a($icon, $url, [
                                        'title' => 'Редактировать',
                                        'aria-label' => 'Редактировать',
                                    ]);
                                }
                            },
                            'delete' => function ($url, ThemeDialog $model, $key) {
                                if ($model->id > 99) {
                                    $url = Url::to(['delete', 'id' => $model->id]);
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                                    return Html::a($icon, $url, [
                                        'title' => 'Удалить',
                                        'aria-label' => 'Удалить',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите удалить тему ' . $model->caption . '?',
                                        'data-method' => 'post',
                                    ]);
                                }
                            },
                        ],
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>