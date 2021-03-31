<?php

use booking\entities\foods\Food;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $food Food */


$this->title = 'Заведение: ' . $food->name;
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <div class="user-view">
        <p>
            <?php
            if ($food->isVisible()) {
                echo Html::a('Скрыть', ['visible', 'id' => $food->id], ['class' => 'btn btn-danger']);
            } else {
                echo Html::a('Показать', ['visible', 'id' => $food->id], ['class' => 'btn btn-primary']);
            }
            ?>
            <?= Html::a('Изменить', ['update', 'id' => $food->id], ['class' => 'btn btn-success']); ?>
            <?= Html::a('Фото', ['photo', 'id' => $food->id], ['class' => 'btn btn-info']); ?>
            <?= Html::a('Адреса', ['address', 'id' => $food->id], ['class' => 'btn btn-info']); ?>
            <?= Html::a('Контакты', ['contact', 'id' => $food->id], ['class' => 'btn btn-info']); ?>
        </p>
        <div class="row">
            <div class="col">
                <ul class="thumbnails">
                    <?php foreach ($food->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail"
                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                     alt="<?= $food->name; ?>"/>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $food,
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
                            'value' => function (Food $model) {
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
                            'label' => 'Кухня',
                            'value' => implode(', ', ArrayHelper::getColumn($food->kitchens, 'name')),
                        ],
                        [
                            'label' => 'Тип',
                            'value' => implode(', ', ArrayHelper::getColumn($food->categories, 'name')),
                        ],
                        [
                            'attribute' => 'meta.title',
                            'label' => 'Заголовок СЕО',
                        ],
                        [
                            'attribute' => 'meta.description',
                            'format' => 'text',
                            'label' => 'Описание СЕО',
                        ],
                        [
                            'attribute' => 'meta.keywords',
                            'label' => 'Ключевые слова СЕО',
                        ],
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Координаты -->
        <div class="card">
            <div class="card-body">
                <table class="table table-adaptive table-striped table-bordered">
                    <th></th>
                    <?php foreach ($food->addresses as $i => $address): ?>
                        <tr>
                            <td width="20px"><?= $i + 1 ?></td>
                            <td><?= $address->city ?></td>
                            <td><?= $address->address ?></td>
                            <td><?= $address->phone ?></td>
                            <td width="80px" data-label="Действия">
                                <a href="<?= Url::to(['delete-address', 'id' => $address->id, 'food_id' => $food->id]) ?>" title="Удалить"><span
                                            class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <!-- Контакты -->
        <div class="card">
            <div class="card-body">
                <table class="table table-adaptive table-striped table-bordered">
                    <th></th>
                    <?php foreach ($food->contactAssign as $contact): ?>
                        <tr>
                            <td width="30px" data-label="Вид связи">
                                <img src="<?= $contact->contact->getThumbFileUrl('photo', 'icon') ?>"/>
                            </td>
                            <td width="40%" data-label="Значение">
                                <?= $contact->value ?>
                            </td>
                            <td data-label="Описание">
                                <?= !empty($contact->description) ? $contact->description : '-' ?>
                            </td>
                            <td width="80px" data-label="Действия">
                                <a href="<?= Url::to(['update-contact', 'id' => $contact->contact_id, 'food_id' => $contact->food_id]) ?>"
                                   title="Изменить"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a href="<?= Url::to(['delete-contact', 'id' => $contact->contact_id, 'food_id' => $contact->food_id]) ?>" title="Удалить"><span
                                            class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
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