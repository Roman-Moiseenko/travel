<?php
/* @var $this yii\web\View */
/* @var $searchModel KitchenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кухня';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\City;
use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\helpers\DialogHelper;
use office\forms\guides\CitySearch;
use office\forms\info\foods\KitchenSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="theme-dialog">
    <p>
        <?= Html::a('Создать Кухню', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'contentOptions' => ['data-label' => 'Название'],
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => 'Ссылка',
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