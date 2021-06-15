<?php



/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\info\events\ProviderSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Провайдеры событий';
$this->params['breadcrumbs'][] = $this->title;


use booking\entities\events\Provider;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="theme-dialog">
    <p>
        <?= Html::a('Создать Провайдера', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'attribute' => 'name',
                        'label' => 'Название',
                        'value' => function (Provider $model) {
                            return Html::a($model->name, Url::to(['view', 'id' => $model->id]));
                        },
                        'format' => 'raw',
                        'contentOptions' => ['data-label' => 'Название'],
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => StatusHelper::listStatus(),
                        'value' => function (Provider $model) {
                            return StatusHelper::statusToHTML($model->status);
                        },
                        'format' => 'raw',
                        'label' => 'Статус',
                        'contentOptions' => ['data-label' => 'Статус'],
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Описание',
                        'contentOptions' => ['data-label' => 'Ссылка'],
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',

                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>