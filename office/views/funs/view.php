<?php

use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\helpers\BookingHelper;
use booking\helpers\cars\CarHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\StatusHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $fun Fun */


$this->title = 'Развлечение: ' . $fun->name;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">

        <p>
            <?php if ($fun->isVerify()) {
                echo Html::a('Активировать', ['active', 'id' => $fun->id], ['class' => 'btn btn-warning']);
            } ?>

            <?php
            //TODO Добавить отдельное окно с выбором причины блокировки ... ?
            if ($fun->isLock()) {
                echo Html::a('Разблокировать', ['unlock', 'id' => $fun->id], ['class' => 'btn btn-success']);
            } else {
                echo Html::a('Заблокировать', ['lock', 'id' => $fun->id], ['class' => 'btn btn-danger']);
            }
            ?>

        </p>

        <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
            <div class="col">
                <ul class="thumbnails">
                    <?php foreach ($fun->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail"
                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_funs_additional'); ?>"
                                     alt="<?= $fun->name; ?>"/>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <?= DetailView::widget([
                    'model' => $fun,
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
                            'value' => Yii::$app->formatter->asHtml($fun->description, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]),
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
                            'value' => Yii::$app->formatter->asHtml($fun->description_en, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]),
                            'format' => 'raw',
                            'label' => 'Описание (En)',
                        ],
                        [
                            'attribute' => 'type_id',
                            'value' => ArrayHelper::getValue($fun, 'type.name'),
                            'label' => 'Категория',
                        ],
                        [
                            'label' => 'Ограничение по возрасту',
                            'value' => BookingHelper::ageLimit($fun->params->ageLimit),
                        ],
                        [
                            'label' => 'Режим работы',
                            'value' => function () use ($fun) {
                                $result = '<table class="table table-adaptive table-striped table-bordered adaptive-width-50">' .
                                    '<tbody>';
                                foreach ($fun->params->workMode as $i => $mode) {
                                    $result .= '<tr>' .
                                        '<td data-label="Характеристика" width="40px">' . WorkModeHelper::week($i) . '</td>' .
                                        '<td data-label="Значение">' . WorkModeHelper::mode($mode) . '</td>';
                                }
                                $result .= '</tr>' .
                                    '</tbody>' .
                                    '</table>';
                                return $result;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'baseCost.adult',
                            'label' => 'Взрослый билет',
                        ],
                        [
                            'attribute' => 'baseCost.child',
                            'label' => 'Детский билет',
                        ],
                        [
                            'attribute' => 'baseCost.preference',
                            'label' => 'Льготный билет',
                        ],
                        [
                            'attribute' => 'legal_id',
                            'label' => 'Организация',
                            'value' => function () use ($fun) {
                                $legal = Legal::findOne($fun->legal_id);
                                return $legal ? Html::a($legal->name, ['legals/view', 'id' => $fun->legal_id]) : '';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Провайдер',
                            'value' => function () use ($fun) {
                                return Html::a($fun->user->username, ['providers/view', 'id' => $fun->user_id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'cancellation',
                            'label' => 'Отмена брони',
                            'value' => BookingHelper::cancellation($fun->cancellation),
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <!-- Координаты -->
        <div class="row pt-4">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header with-border">Характеристики Развлечения</div>
                    <div class="card-body">
                        <table class="table table-adaptive table-striped table-bordered">
                            <tbody>
                            <?php foreach ($fun->values as $value): ?>
                                <tr>
                                    <td data-label="Характеристика"><?= $value->characteristic->name ?></td>
                                    <td data-label="Значение"><?= $value->value ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header with-border">Адрес</div>
                    <div class="card-body">
                        <input class="form-control" type="text" id="address" value="<?= $fun->address->address ?>" readonly>
                        <input type="hidden" id="latitude" value="<?= $fun->address->latitude ?>">
                        <input type="hidden" id="longitude" value="<?= $fun->address->longitude ?>">
                        <div class="row">
                            <div id="map-fun-view" style="width: 100%; height: 200px"></div>
                        </div>
                    </div>
                </div>
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