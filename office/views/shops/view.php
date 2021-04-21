<?php

use booking\entities\admin\Legal;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\shops\ShopTypeHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $shop Shop */


$this->title = 'Магазин: ' . $shop->name;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">

        <p>
            <?php if ($shop->isVerify()) {
                echo Html::a('Активировать', ['active', 'id' => $shop->id], ['class' => 'btn btn-warning']);
            } ?>

            <?php
            //TODO Добавить отдельное окно с выбором причины блокировки ... ?
            if ($shop->isLock()) {
                echo Html::a('Разблокировать', ['unlock', 'id' => $shop->id], ['class' => 'btn btn-success']);
            } else {
                echo Html::a('Заблокировать', ['lock', 'id' => $shop->id], ['class' => 'btn btn-danger']);
            }
            ?>

        </p>
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

        <div class="card">
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $shop,
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'label' => 'ID',
                        ],
                        [
                            'attribute' => 'name',
                            'format' => 'text',
                            'label' => 'Название',
                        ],
                        [
                            'attribute' => 'description',
                            'value' => function (Shop $model) {
                                return Yii::$app->formatter->asHtml($model->description, [
                                    'Attr.AllowedRel' => array('nofollow'),
                                    'HTML.SafeObject' => true,
                                    'Output.FlashCompat' => true,
                                    'HTML.SafeIframe' => true,
                                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                ]);
                            },
                            'format' => 'raw',
                            'label' => 'Описание',
                        ],
                        [
                            'attribute' => 'name_en',
                            'format' => 'text',
                            'label' => 'Название (En)',
                        ],
                        [
                            'attribute' => 'description_en',
                            'value' => function (Shop $model) {
                                return Yii::$app->formatter->asHtml($model->description_en, [
                                    'Attr.AllowedRel' => array('nofollow'),
                                    'HTML.SafeObject' => true,
                                    'Output.FlashCompat' => true,
                                    'HTML.SafeIframe' => true,
                                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                ]);
                            },
                            'label' => 'Описание (En)',
                        ],
                        [
                            'attribute' => 'type_id',
                            'value' => ShopTypeHelper::list()[$shop->type_id],
                            'label' => 'Категория',
                        ],
                        [
                            'attribute' => 'legal_id',
                            'label' => 'Организация',
                            'value' => function () use ($shop) {
                                $legal = Legal::findOne($shop->legal_id);
                                return $legal ? Html::a($legal->name, ['legals/view', 'id' => $shop->legal_id]) : '';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Провайдер',
                            'value' => function () use ($shop) {
                                return Html::a($shop->user->username, ['providers/view', 'id' => $shop->user_id]);
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">Товары</div>
        <div class="card-body">
            <table class="table table-adaptive table-striped">
                <tr></tr>
                <?php foreach ($shop->products as $i => $product): ?>
                <tr>
                    <td width="20px"><?= $i + 1 ?></td>
                    <td><img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'admin') ?>"></td>
                    <td><?= $product->name ?></td>
                    <td><?= CurrencyHelper::stat($product->cost) ?></td>
                    <td><?= $product->views ?></td>
                    <td><?= $product->buys ?></td>
                </tr>
                <?php endforeach; ?>
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