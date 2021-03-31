<?php
/* @var $this yii\web\View */
/* @var $searchModel FoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заведения';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\City;
use booking\entities\booking\tours\Type;
use booking\entities\foods\Food;
use booking\entities\message\ThemeDialog;
use booking\helpers\DialogHelper;
use office\forms\guides\CitySearch;
use office\forms\info\foods\FoodSearch;
use office\forms\info\foods\KitchenSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="theme-dialog">
    <p>
        <?= Html::a('Создать Заведение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card adaptive-width-70">
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
                        'value' => function (Food $model) {
                            return Html::a($model->name, Url::to(['view', 'id' => $model->id]));
                        },
                        'format' => 'raw',
                        'contentOptions' => ['data-label' => 'Название'],
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