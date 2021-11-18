<?php



/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\art\event\EventSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\art\event\Event;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>

<div class="category-index">
    <p>
        <?= Html::a('Создать Событие', Url::to(['create']), ['class' => 'btn btn-success']) ?>
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
                'label' => '#ID',
                'options' => ['width' => '20px', 'style' => 'text-align: center;'],
                'contentOptions' => ['data-label' => 'ID'],
            ],
            [
                'value' => function (Event $model) {
                    return Html::img($model->getThumbFileUrl('photo', 'admin'));
                },
                'format' => 'raw',
                'options' => ['width' => '100px'],
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function (Event $model) {
                    return StatusHelper::statusToHTML($model->status);
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => StatusHelper::listStatus(),
                'contentOptions' => ['data-label' => 'Статус'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Event $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'attribute' => 'description',
                'value' => function (Event $model) {
                    return StringHelper::truncateWords(strip_tags($model->description), 40);

                },
                'format' => 'ntext',
                'label' => 'Описание',
                'contentOptions' => ['data-label' => 'Описание'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>


