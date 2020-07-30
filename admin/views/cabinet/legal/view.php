<?php

use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;



/* @var $user User */
/* @var $legal UserLegal */

$this->title = $legal->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-legal">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $legal->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $legal->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить данную организацию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $legal,
                'attributes' => [
                    [
                        'label' => 'Наименование',
                        'attribute' => 'name',
                    ],
                    [
                        'label' => 'ИНН',
                        'attribute' => 'INN',
                    ],
                    [
                        'label' => 'КПП',
                        'attribute' => 'KPP',
                    ],
                    [
                        'label' => 'ОГРН',
                        'attribute' => 'OGRN',
                    ],
                    [
                        'label' => 'БИК банка',
                        'attribute' => 'BIK',
                    ],
                    [
                        'label' => 'Р/счет',
                        'attribute' => 'account',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
