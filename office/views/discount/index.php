<?php



use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\Discount;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Промо-коды';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="discount-create">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 form-inline">
                        <?= $form
                            ->field($model, 'count')
                            ->textInput(['maxlength' => true, 'class' => 'm-2 form-control form-control-sm', 'style' => 'width: 100px;'])
                            ->label('Сумма бонуса') ?>
                        <?= $form
                            ->field($model, 'repeat')
                            ->textInput(['maxlength' => true, 'class' => 'm-2 form-control form-control-sm', 'style' => 'width: 60px;'])
                            ->label('Кол-во промо') ?>
                    <?= Html::submitButton('Сгенерировать', ['class' => 'btn btn-success', 'id' => 'generate-promo']) ?>
                </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'class' => 'table table-adaptive table-striped table-bordered',
    ],
    'columns' => [
        [
            'label' => 'Статус',
            'value' => function (Discount $model) {
                if ($model->countNotUsed() == 0) {
                    return '<span class="badge badge-primary">used</span>';
                }
                if ($model->countNotUsed() <= 0) {
                    return '<span class="badge badge-secondary">draft</span>';
                }
                return '<span class="badge badge-success">new</span>';
            },
            'format' => 'raw',
            'options' => ['style' => 'width: 100px'],
            'contentOptions' => ['data-label' => 'Статус'],
        ],
        [
            'attribute' => 'promo',
            'label' => 'Промо-код',
            'contentOptions' => ['data-label' => 'Промо-код'],
        ],
        [
            'attribute' => 'percent',
            'value' => function (Discount $model) {
                return $model->percent . '%';
            },
            'label' => 'Скидка',
            'contentOptions' => ['data-label' => 'Скидка'],
        ],
        [
            'attribute' => 'count',
            'label' => 'Кол-во применений',
            'value' => function (Discount $model) {
                return $model->count < 0 ? 'Заблокирован' : $model->count;
            },
            'options' => ['width' => '100px'],
            'contentOptions' => ['data-label' => 'Бонус'],
        ],
        [
            'value' => function (Discount $model) {
                if ($model->count < 0) return 'Заблокирован';
                return $model->countNotUsed();
            },
            'label' => 'Остаток',
            'contentOptions' => ['data-label' => 'Остаток'],
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $url = Url::to(['/discount/delete', 'id' => $model->id]);
                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                    return Html::a($icon, $url, [
                        'title' => 'Заблокировать',
                        'aria-label' => 'Заблокировать',
                        'data-pjax' => 0,
                        'data-confirm' => 'Вы уверены, что хотите удалить Промо-код ' . $model->promo . '?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>