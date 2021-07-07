<?php

use admin\widgest\StatusActionWidget;
use booking\entities\booking\trips\placement\Placement;
use booking\entities\booking\trips\Trip;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $trip Trip */
/* @var $placement Placement */

$this->title = $placement->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Проживание', 'url' => ['/trip/placement/index', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = $placement->name;
?>

<p>
    <?= Html::a('Редактировать', Url::to(['/trip/placement/update', 'id' => $trip->id, 'placement_id' => $placement->id]), ['class' => 'btn btn-success']) ?>

    <?= Html::a('Фотографии', Url::to(['trip/placement/photo', 'id' => $trip->id, 'placement_id' => $placement->id]), ['class' => 'btn btn-success']) ?>
    <?= Html::a('Питание', Url::to(['trip/placement/meals', 'id' => $trip->id, 'placement_id' => $placement->id]), ['class' => 'btn btn-success']) ?>
    <?= Html::a('Номера', Url::to(['trip/placement/rooms', 'id' => $trip->id, 'placement_id' => $placement->id, 'room_id' => -1]), ['class' => 'btn btn-success']) ?>
</p>


<div class="trip-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $placement,
                'attributes' => [
                    [
                        'attribute' => 'type_id',
                        'value' => ArrayHelper::getValue($placement, 'type.name'),
                        'label' => 'Главная категория',
                    ],

                ],
            ]) ?>
            <?= Yii::$app->formatter->asHtml($placement->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Описание EN</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $placement,
                'attributes' => [
                    [
                        'attribute' => 'name_en',
                        'label' => 'Наименование (En)',
                    ],
                ],
            ]) ?>
            <?= Yii::$app->formatter->asHtml($placement->description_en, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Расположение</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $placement->address->address?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $placement->address->latitude?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $placement->address->longitude?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div id="map-view" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header with-border">Удобства в Объекте проживания</div>
        <div class="card-body">
            <?php foreach ($placement->getComfortsSortCategory() as $i => $category): ?>
                <div class="card card-info">
                    <div class="card-header"><i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?></div>
                    <div class="card-body">
                        <?php foreach ($category['items'] as $comfort): ?>
                            <div>
                                <?= $comfort['name'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Фотографии (общие)</div>
        <div class="card-body">
            <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
                <div class="col">
                    <ul class="thumbnails">
                        <?php foreach ($placement->photos as $i => $photo): ?>
                            <li class="image-additional"><a class="thumbnail"
                                                            href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                                            target="_blank">
                                    <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                         alt="<?= $placement->name; ?>"/>
                                </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Номера</div>
        <div class="card-body">
            <?php foreach ($placement->rooms as $room): ?>
            <div class="card card-info">
                <div class="card-header">
                    <?= $room->name ?>
                    <?= Html::a('Редактировать', Url::to(['trip/placement/rooms', 'id' => $trip->id, 'placement_id' => $placement->id, 'room_id' => $room->id]), ['class' => 'btn btn-primary ml-2']) ?>
                </div>
                <div class="card-body">
                    <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
                        <div class="col">
                            <ul class="thumbnails">
                                <?php foreach ($room->photos as $i => $photo): ?>
                                    <li class="image-additional"><a class="thumbnail"
                                                                    href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                                                    target="_blank">
                                            <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                                 alt="<?= $room->name; ?>"/>
                                        </a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?= DetailView::widget([
                        'model' => $room,
                        'attributes' => [
                            [
                                'attribute' => 'quantity',
                                'label' => 'Количество номеров',
                            ],
                            [
                                'attribute' => 'capacity',
                                'label' => 'Вместительность (чел)',
                            ],
                            [
                                'attribute' => 'cost',
                                'value' => CurrencyHelper::get($room->cost),
                                'format' => 'raw',
                                'label' => 'Стоимость',
                            ],
                            [
                                'attribute' => 'shared',
                                'value' => $room->shared ? 'Да' : 'Нет',
                                'label' => 'Общий номер',
                            ],
                            [
                                'attribute' => 'meals',
                                'value' => $room->Meals(),
                                'label' => 'Питание',
                            ],
                        ],
                    ])?>
                    <div class="row pt-3">
                        <div class="col-sm-12">
                            <?php foreach ($room->getComfortsSortCategory() as $i => $category): ?>
                                <div class="card card-dark my-1">
                                    <div class="card-header"><i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?></div>
                                    <div class="card-body">
                                        <?php foreach ($category['items'] as $comfort): ?>
                                            <div>
                                                <?= $comfort['name'] ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Питание</div>
        <div class="card-body">
            <?php if (empty($placement->meals)): ?>
                <label>Питание не предоставляется</label>
            <?php else: ?>
                <table>
                    <?php foreach ($placement->mealsAssignment as $assignment): ?>
                        <tr>
                            <th width="40px"><?= $assignment->meals->mark ?></th>
                            <td width="260px"><?= $assignment->meals->name ?></td>
                            <td><?= CurrencyHelper::get($assignment->cost) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

</div>
