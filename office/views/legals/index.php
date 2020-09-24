<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\LegalsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="legals-list">

        <div class="card">
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'options' => ['width' => '20px',]
                        ],
                        [
                            'attribute' => 'INN',
                            'label' => 'ИНН'
                        ],
                        [
                            'attribute' => 'name',
                            'label' => 'Название (ссылка+)'
                        ],
                        [
                            'attribute' => 'caption',

                            'label' => 'Заголовок (ссылка+)'
                        ],
                        [
                            'attribute' => 'user_id',
                            'label' => 'Провайдер (ссылка+)'
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
                            'label' => 'Создан',
                        ],
                    ],
                ]); ?>
            </div>
        </div>

</div>
