<?php


use admin\forms\shops\ProductSearch;
use booking\entities\shops\products\Category;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\helpers\CurrencyHelper;
use booking\helpers\shops\CategoryHelper;
use booking\helpers\StatusHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $shop Shop */
/* @var $model CostModalForm */

$js = <<<JS
$('#costModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); 
  let _id = button.data('id'); 
  
  let _cost = button.data('cost'); 
  let _quantity = button.data('quantity'); 
  let _discount = button.data('discount');   
//  let _class_name = button.data('class-name'); 

  let modal = $(this);
  modal.find('#id').val(_id);
  modal.find('#cost').val(_cost);
  modal.find('#quantity').val(_quantity);
  modal.find('#discount').val(_discount);  
  //modal.find('#class_name').val(_class_name);

})
JS;
$this->registerJs($js);

$this->title = 'Товары';
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
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
                'value' => function (Product $model) {
                    return '<img src="' . $model->mainPhoto->getThumbFileUrl('file', 'admin') . '">';
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Product $model) {
                    return Html::a(Html::encode($model->name), ['/shop/product/view', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'attribute' => 'category_id',
                'label' => 'Категория',
                'value' => function (Product $model) {
                    return $model->category->name;
                },
                'filter' => CategoryHelper::list(),
                'contentOptions' => ['data-label' => 'Категория'],

            ],
            [
                'attribute' => 'active',
                'label' => 'Статус',
                'value' => function (Product $model) {
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
                'value' => function (Product $model) {
                    return CurrencyHelper::stat($model->cost);
                },
                'format' => 'raw',

                'contentOptions' => ['data-label' => 'Текущая цена'],
            ],
            [
                'attribute' => 'discount',
                'label' => 'Скидка',
                'value' => function (Product $model) {
                    return empty($model->discount)
                        ? '<scan class="badge badge-danger">нет</scan>'
                        : '<scan class="badge badge-primary">' . $model->discount . ' %</scan>';
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Скидка'],
            ],
            [
                'attribute' => 'quantity',
                'label' => 'В наличии',
                'contentOptions' => ['data-label' => 'В наличии'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{cost} | {active} | {view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye"></i>',
                            Url::to(['/shop/product/view', 'id' => $model->id]),
                            [
                                'class' => 'link-admin',
                                'title' => 'Просмотр',
                                'aria-label' => 'Просмотр',
                                'data-pjax' => 0,
                                'data-method' => 'post',
                            ]);
                    },
                    'cost' => function ($url, Product $model, $key) {
                        return '
                            <a title="Ценообразование" type="button" class="link-admin" data-toggle="modal" href=""
                                    data-target="#costModal"
                                    data-id="' . $model->id . '"
                                    data-class-name=""
                                    data-cost="' . $model->cost . '"
                                    data-quantity="' . $model->quantity . '"
                                    data-discount="' . $model->discount . '"
                                    ><i class="fas fa-ruble-sign"></i>
                            </a>';
                    },
                    'active' => function ($url, Product $model, $key) {
                        if ($model->isActive()) {
                            return Html::a('<i class="fas fa-lock-open"></i>',
                                Url::to(['/shop/product/draft', 'id' => $model->id]),
                                [
                                    'class' => 'link-admin',
                                    'title' => 'Снять с продажи',
                                    'aria-label' => 'Снять с продажи',
                                    'data-pjax' => 0,
                                    'data-method' => 'post',
                                ]);
                        } else {
                            return Html::a('<i class="fas fa-lock"></i>',
                                Url::to(['/shop/product/active', 'id' => $model->id]),
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
                <?= $form->field($model, 'quantity')->textInput(['id' => 'quantity'])->label('Количество') ?>
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