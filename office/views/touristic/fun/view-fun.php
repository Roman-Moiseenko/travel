<?php

use booking\entities\admin\Legal;
use booking\entities\touristic\fun\Category;
use booking\entities\touristic\fun\Fun;
use booking\helpers\BookingHelper;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;


/* @var $this View */
/* @var $fun Fun|null */
/* @var $category Category */

$this->title = $fun->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view-category', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Изменить';

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
    <p>
        <?= Html::a('Редактировать', Url::to(['update-fun', 'id' => $category->id]), ['class' => 'btn btn-warning']) ?>
        <?php if ($fun->isActive())
            echo Html::a('В черновик', Url::to(['draft-fun', 'id' => $category->id]), ['class' => 'btn btn-secondary']);
        else
            echo Html::a('Опубликовать', Url::to(['active-fun', 'id' => $category->id]), ['class' => 'btn btn-primary']);
        ?>
        <?= Html::a('Добавить Фотографии', Url::to(['photo-fun', 'id' => $category->id]), ['class' => 'btn btn-success']) ?>
    </p>


    <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
        <div class="col">
            <ul class="thumbnails">
                <?php foreach ($fun->photos as $i => $photo): ?>
                    <li class="image-additional"><a class="thumbnail"
                                                    href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                            <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                 alt="<?= $fun->name; ?>"/>
                        </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">Основные</div>
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
                        'attribute' => 'title',
                        'format' => 'text',
                        'label' => 'Заголовок H1',
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Описание',
                    ],
                    [
                        'attribute' => 'content',
                        'value' => Yii::$app->formatter->asHtml($fun->content, [
                            'Attr.AllowedRel' => array('nofollow'),
                            'HTML.SafeObject' => true,
                            'Output.FlashCompat' => true,
                            'HTML.SafeIframe' => true,
                            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                        ]),
                        'format' => 'raw',
                        'label' => 'Содержимое',
                    ],
                    [
                            'value' => (!empty($fun->contact->phone) ? 'Телефон ' . $fun->contact->phone . '<br>' : '') .
                            (!empty($fun->contact->url) ? 'Ссылка ' . $fun->contact->url . '<br>' : '').
                            (!empty($fun->contact->email) ? 'Электронная почта ' . $fun->contact->email . '<br>' : ''),
                        'format' => 'raw',
                        'label' => 'Контакты',
                    ]
                ],
            ]) ?>
        </div>
    </div>

    <!-- Координаты -->
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
    <div class="card card-default">
        <div class="card-header">SEO</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $fun->meta,
                'attributes' => [
                    [
                        'attribute' => 'title',
                        'label' => 'Заголовок',
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Описание',
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