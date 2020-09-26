<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use booking\helpers\StatusHelper;
use frontend\assets\MagnificPopupAsset;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $tour Tour */


$this->title = 'Тур: ' . $tour->name;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
MagnificPopupAsset::register($this);
?>
<div class="user-view">

    <p>
        <?php if ($tour->status == StatusHelper::STATUS_VERIFY) {
            echo Html::a('Активировать', ['active', 'id' => $tour->id], ['class' => 'btn btn-warning']);
        } ?>

        <?php
        //TODO Добавить отдельное окно с выбором причины блокировки ... ?
        if ($tour->status == StatusHelper::STATUS_LOCK) {
            echo Html::a('Разблокировать', ['unlock', 'id' => $tour->id], ['class' => 'btn btn-success']);
        } else {
            echo Html::a('Заблокировать', ['lock', 'id' => $tour->id], ['class' => 'btn btn-danger']);
        }

        ?>

    </p>

    <div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
        <div class="col">
            <ul class="thumbnails">
                <?php foreach ($tour->photos as $i => $photo): ?>
                        <li class="image-additional"><a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                <img src="<?= $photo->getThumbFileUrl('file', 'catalog_tours_additional'); ?>"
                                     alt="<?= $tour->name; ?>"/>
                            </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <?= DetailView::widget([
                'model' => $tour,
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
                        'format' => 'ntext',
                        'label' => 'Описание',
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