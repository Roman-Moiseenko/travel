<?php

use booking\entities\realtor\Landowner;
use frontend\assets\MagnificPopupAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

/* @var $landowner Landowner */

$this->title = $landowner->name;
$this->params['breadcrumbs'][] = ['label' => 'Землевладения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>

<div>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $landowner->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Фото', ['photo', 'id' => $landowner->id], ['class' => 'btn btn-primary']) ?>
        <?= $landowner->isActive()
            ? Html::a('В черновик', ['draft', 'id' => $landowner->id], ['class' => 'btn btn-secondary'])
            : Html::a('Активировать', ['activate', 'id' => $landowner->id], ['class' => 'btn btn-success'])
        ?>
        <?= Html::a('Удалить', ['delete', 'id' => $landowner->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить Землевладение?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
        <div class="col">
            <ul class="thumbnails">
                <?php foreach ($landowner->photos as $i => $photo): ?>
                    <li class="image-additional"><a class="thumbnail"
                                                    href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                            <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                 alt="<?= $landowner->name; ?>"/>
                        </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $landowner,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'label' => 'Название'
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => 'Ссылка'
                    ],
                    [
                        'attribute' => 'caption',
                        'label' => 'Землевладелец'
                    ],
                    [
                        'attribute' => 'email',
                        'label' => 'Почта'
                    ],
                    [
                        'attribute' => 'phone',
                        'label' => 'Телефон'
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Сведения об Участках</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $landowner,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'count',
                        'label' => 'Кол-во'
                    ],
                    [
                        'attribute' => 'size',
                        'label' => 'Мин.размер'
                    ],
                    [
                        'attribute' => 'distance',
                        'label' => 'До Калининграда (км)'
                    ],
                    [
                        'attribute' => 'cost',
                        'label' => 'Мин.цена за сотку'
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Описание'
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header with-border">Содержимое</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($landowner->text, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>


            <div class="card card-secondary">
                <div class="card-header with-border">Расположение</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $landowner->address->address?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $landowner->address->latitude?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $landowner->address->longitude?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div id="map-view" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>


    <div class="card card-secondary">
        <div class="card-header with-border">Для SEO</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $landowner,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'format' => 'text',
                        'label' => 'Заголовок'
                    ],
                    [
                        'attribute' => 'meta.description',
                        'format' => 'ntext',
                        'label' => 'Описание'
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'format' => 'text',
                        'label' => 'Ключевые слова'
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
