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
            <?php foreach ($shop->photos as $i => $photo): ?>
                <li class="image-additional"><a class="thumbnail"
                                                href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                        <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= $shop->name; ?>"/>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="card my-3">
    <div class="card-body">
        <p>
            <?= Yii::$app->formatter->asNtext($product->description) ?>
        </p>
        ХАРАКТЕРИСТИКИ
        <table class="table w-50">
            <?php if (!empty($product->collection)): ?>
                <tr>
                    <td class="characteristic key"><?= Lang::t('Коллекция: ') ?></td>
                    <td class="characteristic value"><?= $product->collection ?></td>
                </tr>
            <?php endif; ?>
            <?php if (!empty($product->color)): ?>
                <tr>
                    <td class="characteristic key"><?= Lang::t('Цвет: ') ?></td>
                    <td class="characteristic value"><?= $product->color ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td class="characteristic key"><?= Lang::t('Производство: ') ?></td>
                <td class="characteristic value"><?= ManufacturedHelper::list()[$product->manufactured_id] ?></td>
            </tr>
            <tr>
                <td class="characteristic key"><?= Lang::t('Размеры (ШхВхГ см): ') ?></td>
                <td class="characteristic value"><?= $product->size->width . 'x' . $product->size->height . 'x' . $product->size->depth ?></td>
            </tr>
            <tr>
                <td class="characteristic key"><?= Lang::t('Масса (г): ') ?></td>
                <td class="characteristic value"><?= $product->weight ?></td>
            </tr>
        </table>
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




