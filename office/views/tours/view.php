<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use booking\helpers\StatusHelper;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $tour Tour */


$this->title = 'Тур: ' . $tour->name;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['index']];

\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?php if ($tour->status == StatusHelper::STATUS_VERIFY) {
            echo Html::a('Активировать', ['active', 'id' => $tour->id], ['class' => 'btn btn-warning']);
        } ?>
        <?php if ($tour->status == StatusHelper::STATUS_LOCK) {
            echo Html::a('Разблокировать', ['unlock', 'id' => $tour->id], ['class' => 'btn btn-success']);
        } else {
            echo Html::a('Заблокировать', ['lock', 'id' => $tour->id], ['class' => 'btn btn-danger']);
        }

        ?>

    </p>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $tour,
                'attributes' => [
                    [
                        'attribute' => 'id',
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'text',
                    ],

                ],
            ]) ?>
        </div>
    </div>

</div>
