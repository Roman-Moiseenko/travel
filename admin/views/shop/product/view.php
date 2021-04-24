<?php


use booking\entities\shops\products\Material;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\helpers\shops\CategoryHelper;
use booking\helpers\shops\ManufacturedHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $shop Shop */
/* @var $product Product */

$this->title = 'Товар ' . $product->name;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/shop/products/' . $shop->id]];
$this->params['breadcrumbs'][] = $product->name;

MagnificPopupAsset::register($this);
?>
    <div>
        <p>
            <?php if ($product->isActive()) {
                echo Html::a('Снять с продажи', ['draft', 'id' => $product->id], ['class' => 'btn btn-secondary']);
            } else {
                echo Html::a('Активировать для продажи', ['active', 'id' => $product->id], ['class' => 'btn btn-warning']);
            }
            ?>

            <?= Html::a('Редактировать', ['update', 'id' => $product->id], ['class' => 'btn btn-success']); ?>
            <?= Html::a('Удалить', ['delete', 'id' => $product->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить ' . $product->name . '?',
                        'method' => 'post',
                    ],
                ]); ?>


        </p>
        <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
            <div class="col">
                <ul class="thumbnails">
                    <?php foreach ($product->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail"
                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                     alt="<?= $product->name; ?>"/>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $product,
                    'attributes' => [
                        [
                            'attribute' => 'category_id',
                            'value' => CategoryHelper::name($product->category_id),
                            'label' => 'Категория',
                        ],
                        [
                            'attribute' => 'name',
                            'label' => 'Наименование',
                        ],
                        [
                            'attribute' => 'description',
                            'label' => 'Описание',
                        ],
                        [
                            'attribute' => 'cost',
                            'label' => 'Цена (руб)',
                        ],
                        [
                            'attribute' => 'discount',
                            'label' => 'Скидка (%)',
                        ],
                        [
                            'attribute' => 'name_en',
                            'label' => 'Наименование (En)',
                        ],
                        [
                            'attribute' => 'description_en',
                            'label' => 'Описание (En)',
                        ],
                        [
                            'attribute' => 'weight',
                            'label' => 'Масса (г)',
                        ],
                        [
                            'attribute' => 'weight',
                            'value' => $product->size->width . 'x' . $product->size->height . 'x' . $product->size->depth,
                            'label' => 'Размеры',
                        ],
                        [
                            'attribute' => 'collection',
                            'label' => 'Коллекция/серия',
                        ],
                        [
                            'attribute' => 'article',
                            'label' => 'Артикул',
                        ],
                        [
                            'attribute' => 'color',
                            'label' => 'Цвет',
                        ],
                        [
                            'attribute' => 'manufactured_id',
                            'value' => ManufacturedHelper::list()[$product->manufactured_id],
                            'label' => 'Производство',
                        ],
                        [
                            'attribute' => '',
                            'value' => implode(',',
                                array_map(function (Material $material) {
                                    return $material->name;
                                }, $product->materials
                                )),
                            'label' => 'Материал',
                        ],
                        [
                            'attribute' => 'deadline',
                            'label' => 'Срок изготовления',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>


<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>