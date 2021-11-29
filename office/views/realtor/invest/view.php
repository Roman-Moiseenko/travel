<?php



/* @var $this \yii\web\View */
/* @var $land \booking\entities\realtor\land\Land */

use yii\widgets\DetailView;

$this->title = $land->name;
$this->params['breadcrumbs'][] = ['label' => 'Инвестиционные участки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= \yii\helpers\Html::a('Изменить', \yii\helpers\Url::to(['update', 'id' => $land->id]), ['class' => 'btn btn-primary']) ?>
    <?= \yii\helpers\Html::a('Нарисовать Участок', \yii\helpers\Url::to(['points', 'id' => $land->id]), ['class' => 'btn btn-success']) ?>

</p>

<div class="card card-secondary">
    <div class="card-header with-border">Медиа</div>
    <div class="card-body">
        <a class="pt-4" href="<?= $land->getUploadedFileUrl('photo')?>">
            <img class="img-responsive-2" src="<?= $land->getThumbFileUrl('photo', 'office_view')?>" alt=""/>
        </a>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $land,
            'attributes' => [
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                ],
                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                ],
                [
                    'attribute' => 'cost',
                    'label' => 'Стоимость',
                ],
                [
                    'attribute' => 'title',
                    'label' => 'Заголовок',
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Краткое описание',
                ],
            ],
        ]) ?>
    </div>
</div>


<div class="card card-secondary">
    <div class="card-header with-border">Описание</div>
    <div class="card-body">
        <?= Yii::$app->formatter->asHtml($land->content, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
</div>


<div class="card card-secondary">
    <div class="card-header with-border">Расположение</div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <input id="bookingaddressform-address" class="form-control" width="100%"
                       value="<?= $land->address->address ?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-latitude" class="form-control" width="100%"
                       value="<?= $land->address->latitude ?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-longitude" class="form-control" width="100%"
                       value="<?= $land->address->longitude ?>" disabled>
            </div>
        </div>
        <div class="row">
            <div id="map-view" style="width: 100%; height: 400px"></div>
        </div>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">SEO</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $land->meta,
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