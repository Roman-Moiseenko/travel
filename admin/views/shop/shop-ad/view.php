<?php

use admin\widgest\StatusActionWidget;
use booking\entities\admin\Contact;
use booking\entities\shops\AdShop;
use booking\helpers\BookingHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\shops\ShopTypeHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $shop AdShop */


$this->title = $shop->name . ' / ' . $shop->name_en;
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = $shop->name;
MagnificPopupAsset::register($this);

?>

    <div class="form-group d-flex">
        <div>
            <?= StatusActionWidget::widget([
                'object_status' => $shop->status,
                'object_id' => $shop->id,
                'object_type' => BookingHelper::BOOKING_TYPE_SHOP_AD,
            ]); ?>
        </div>
        <div class="ml-auto">
            <?= !empty($shop->public_at) ? ' Прошел модерацию <i class="far fa-calendar-alt"></i> ' . date('d-m-y', $shop->public_at) : '' ?>
        </div>
    </div>
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

    <div class="card card-secondary">
        <div class="card-header with-border">Описание / Описание EN</div>
        <div class="card-body">
            <div>
                <?= DetailView::widget([
                    'model' => $shop,
                    'attributes' => [
                        [
                            'attribute' => 'type_id',
                            'value' => ShopTypeHelper::list()[$shop->type_id],
                            'label' => 'Тип магазина',
                        ],
                        [
                            'attribute' => 'legal_id',
                            'value' => $shop->legal->name,
                            'label' => 'Организация',
                        ],
                        [
                            'value' => Yii::$app->formatter->asHtml($shop->description, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]),
                            'label' => 'Описание',
                        ],
                        [
                            'value' => Yii::$app->formatter->asHtml($shop->description_en, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]),
                            'label' => 'Описание EN',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Режим работы / Контакты</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php foreach ($shop->workModes as $i => $workMode) {
                        if ($workMode->day_begin != '')
                            echo '' . WorkModeHelper::week($i) . ':&#160;<i class="far fa-clock"></i>&#160;' . $workMode->day_begin . ' - ' . $workMode->day_end . '<br>';
                    } ?>

                </div>
                <div class="col-sm-6">
                    <table class="table">
                        <tbody>
                        <?php foreach ($shop->contactAssign as $contact): ?>
                            <tr>
                                <th width="20px"><img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/></th>
                                <th>
                                    <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                                        <?= Html::encode($contact->value) ?>
                                    <?php else: ?>
                                        <a href="<?= $contact->contact->prefix . $contact->value ?>"
                                           target="_blank" rel="noopener noreferrer nofollow"><?= Html::encode($contact->value) ?></a>
                                    <?php endif; ?>
                                </th>
                                <td><?= Html::encode($contact->description) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Адреса</div>
        <div class="card-body">
            <table class="table">
                <tbody>
            <?php foreach ($shop->addresses as $address):?>
                <tr>
                    <th width="20px"><i class="fas fa-map-marked"></i></th>
                    <td><?= $address->address ?></td>
                    <th width="20px"><i class="fas fa-phone-alt"></i></th>
                    <td><?= $address->phone ?></td>
                </tr>
            <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/shop-ad/update/' . $shop->id]), ['class' => 'btn btn-success']) ?>
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