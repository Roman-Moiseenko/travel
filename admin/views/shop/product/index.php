<?php


use admin\forms\shops\ProductSearch;
use booking\entities\shops\products\Category;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\helpers\shops\CategoryHelper;
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
//  let _class_name = button.data('class-name'); 

  let modal = $(this);
  modal.find('#id').val(_id);
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
                    return '<img src="' . $model->mainPhoto->getThumbFileUrl('file', 'admin') .'">';
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
                    return $model->active ? 'Активный' : 'Черновик';
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => [false => 'Черновик', true => 'Активный'],
                'contentOptions' => ['data-label' => 'Статус'],
            ],

            [
                'attribute' => 'cost',
                'label' => 'Текущая цена',
                'contentOptions' => ['data-label' => 'Текущая цена'],
            ],
            [
                'attribute' => 'quantity',
                'label' => 'В наличии',
                'contentOptions' => ['data-label' => 'В наличии'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {cost}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = Url::to(['/shop/product/view', 'id' => $model->id]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                        return Html::a($icon, $url, [
                            'title' => 'Просмотр',
                            'aria-label' => 'Просмотр',
                            'data-pjax' => 0,
                            'data-method' => 'post',
                        ]);
                    },
                    'cost' => function ($url, $model, $key) {
                       // $url = Url::to(['/shop/product/view', 'id' => $model->id]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                        return '
                            <button title="Alt" type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#costModal"
                                    data-id="'. $model->id.'"
                                    data-class-name=""
                                    style="color: #f4ffff; font-size: 1rem">$$
                            </button>';
                    },
                ],
            ],
        ],
    ]); ?>
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