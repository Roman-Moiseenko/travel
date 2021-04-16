<?php


use admin\forms\shops\AdProductSearch;
use booking\entities\shops\AdShop;
use booking\entities\shops\products\AdProduct;
use booking\forms\shops\CostModalForm;
use booking\helpers\CurrencyHelper;
use booking\helpers\shops\CategoryHelper;
use booking\helpers\StatusHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel AdProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $shop AdShop */
/* @var $model CostModalForm */

$js = <<<JS
$('#costModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); 
  let _id = button.data('id'); 
  
  let _cost = button.data('cost');
  let _discount = button.data('discount');

  let modal = $(this);
  modal.find('#id').val(_id);
  modal.find('#cost').val(_cost);
  modal.find('#discount').val(_discount);  


})
JS;
$this->registerJs($js);

$this->title = 'Товары';
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop-ad/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Товар', Url::to(['create', 'id' => $shop->id]), ['class' => 'btn btn-success']) ?>
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
                'label' => '#ID',
                'options' => ['width' => '20px', 'style' => 'text-align: center;'],
                'contentOptions' => ['data-label' => 'ID'],
            ],
            [
                'attribute' => 'main_photo_id',
                'label' => '',
                'value' => function (AdProduct $model) {
                    return '<img src="' . $model->mainPhoto->getThumbFileUrl('file', 'admin') . '">';
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'name',
                'value' => function (AdProduct $model) {
                    return Html::a(Html::encode($model->name), ['/shop-ad/product/', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'attribute' => 'category_id',
                'label' => 'Категория',
                'value' => function (AdProduct $model) {
                    return $model->category->name;
                },
                'filter' => CategoryHelper::list(),
                'contentOptions' => ['data-label' => 'Категория'],

            ],
            [
                'attribute' => 'active',
                'label' => 'Статус',
                'value' => function (AdProduct $model) {
                    return StatusHelper::check($model->active, [true => 'Активный', false => 'Черновик']);
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => [false => 'Черновик', true => 'Активный'],
                'contentOptions' => ['data-label' => 'Статус'],
            ],

            [
                'attribute' => 'cost',
                'label' => 'Текущая цена',
                'value' => function (AdProduct $model) {
                    return CurrencyHelper::stat($model->cost);
                },
                'format' => 'raw',

                'contentOptions' => ['data-label' => 'Текущая цена'],
            ],
            [
                'attribute' => 'discount',
                'label' => 'Скидка',
                'value' => function (AdProduct $model) {
                    return empty($model->discount)
                        ? '<scan class="badge badge-danger">нет</scan>'
                        : '<scan class="badge badge-primary">' . $model->discount . ' %</scan>';
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Скидка'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{cost} | {active} | {view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye"></i>',
                            Url::to(['/shop-ad/product/', 'id' => $model->id]),
                            [
                                'class' => 'link-admin',
                                'title' => 'Просмотр',
                                'aria-label' => 'Просмотр',
                                'data-pjax' => 0,
                                'data-method' => 'post',
                            ]);
                    },
                    'cost' => function ($url, AdProduct $model, $key) {
                        return '
                            <a title="Ценообразование" type="button" class="link-admin" data-toggle="modal" href=""
                                    data-target="#costModal"
                                    data-id="' . $model->id . '"
                                    data-class-name=""
                                    data-cost="' . $model->cost . '"
                                    data-discount="' . $model->discount . '"
                                    ><i class="fas fa-ruble-sign"></i>
                            </a>';
                    },
                    'active' => function ($url, AdProduct $model, $key) {
                        if ($model->isActive()) {
                            return Html::a('<i class="fas fa-lock-open"></i>',
                                Url::to(['/shop/product-ad/draft', 'id' => $model->id]),
                                [
                                    'class' => 'link-admin',
                                    'title' => 'Снять с продажи',
                                    'aria-label' => 'Снять с продажи',
                                    'data-pjax' => 0,
                                    'data-method' => 'post',
                                ]);
                        } else {
                            return Html::a('<i class="fas fa-lock"></i>',
                                Url::to(['/shop/product-ad/active', 'id' => $model->id]),
                                [
                                    'class' => 'link-admin',
                                    'title' => 'Активировать для продажи',
                                    'aria-label' => 'Активировать для продажи',
                                    'data-pjax' => 0,
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


<div class="modal fade" id="costModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="translateModalLabel">Ценообразование</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
            ]); ?>
            <div class="modal-body">
                <?= $form->field($model, 'cost')->textInput(['id' => 'cost'])->label('Цена') ?>
                <?= $form->field($model, 'discount')->textInput(['id' => 'discount'])->label('Скидка') ?>
                <?= $form->field($model, 'id')->textInput(['type' => 'hidden', 'id' => 'id'])->label(false) ?>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>