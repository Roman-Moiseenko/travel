<?php

use booking\entities\admin\Contact;
use booking\entities\Lang;
use booking\entities\shops\Delivery;
use booking\entities\shops\products\Material;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\forms\booking\ReviewForm;
use booking\helpers\CurrencyHelper;

use booking\helpers\ReviewHelper;
use booking\helpers\shops\CategoryHelper;
use booking\helpers\shops\ManufacturedHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\assets\SwiperAsset;
use frontend\widgets\GalleryWidget;
use frontend\widgets\legal\BookingObjectWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;

use frontend\widgets\reviews\NewReviewProductWidget;
use frontend\widgets\reviews\ReviewsWidget;
use frontend\widgets\shop\ShopWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $product Product */
/* @var $this \yii\web\View */


$this->title = 'Товар: ' . $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->shop->name, 'url' => Url::to(['/shops/view', 'id' => $product->shop->id])];
$this->params['breadcrumbs'][] = $product->name;

MagnificPopupAsset::register($this);
?>

<!-- ФОТО И КОРЗИНА -->
<div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
    <div class="col">
        <ul class="thumbnails">
            <?php foreach ($product->photos as $i => $photo): ?>
                <li class="image-additional"><a class="thumbnail"
                                                href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                        <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"/>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="card my-3">
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




