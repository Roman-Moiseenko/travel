<?php



/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\photos\PageSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use booking\entities\photos\Page;
use booking\helpers\PostHelper;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Публикации';
?>
<p>
    <?= Html::a('Создать Публикацию', Url::to('page/create'), ['class' => 'btn btn-success']) ?>
</p>

<div class="card">
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
                    'attribute' => 'title',
                    'value' => function (Page $model) {
                        return Html::a($model->title, ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'label' => 'Название',
                    'contentOptions' => ['data-label' => 'Название'],
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                    'label' => 'Создан',
                    'contentOptions' => ['data-label' => 'Создан'],
                ],
                [
                    'attribute' => 'status',
                    'filter' => PostHelper::statusList(),
                    'value' => function (Page $model) {
                        return PostHelper::statusLabel($model->status);
                    },
                    'format' => 'raw',
                    'label' => 'Статус',
                    'contentOptions' => ['data-label' => 'Статус'],
                ],

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, Page $model, $key) {
                            if ($model->isDraft()) {
                                $url = Url::to(['activate', 'id' => $model->id]);
                                $icon = Html::tag('i', '', ['class' => "fas fa-play", 'style' => 'color: #ffc107']);
                                return Html::a($icon, $url, [
                                    'title' => 'Активировать',
                                    'aria-label' => 'Активировать',
                                    'data-pjax' => 0,
                                    'data-confirm' => 'Вы уверены, что хотите Опубликовать ' . $model->title . '?',
                                    'data-method' => 'post',
                                ]);
                            } else {
                                $url = Url::to(['draft', 'id' => $model->id]);
                                $icon = Html::tag('i', '', ['class' => "fas fa-lock", 'style' => 'color: #dc3545']);
                                return Html::a($icon, $url, [
                                    'title' => 'В Черновик',
                                    'aria-label' => 'В Черновик',
                                    'data-pjax' => 0,
                                    'data-confirm' => 'Вы уверены, что хотите Снять с публикации ' . $model->title . '?',
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
