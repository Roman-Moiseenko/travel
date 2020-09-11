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
        <?= Html::a('Контакты', ['contacts', 'id' => $legal->id], ['class' => 'btn btn-info ml-5']) ?>
    </p>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
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
    <div class="card card-secondary">
        <div class="card-header with-border">Дополнительно</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $legal,
                'attributes' => [
                    [
                        'label' => 'Заголовок (торговая марка)',
                        'attribute' => 'caption',
                    ],
                    [
                        'label' => 'Адрес',
                        'attribute' => 'address.address',
                    ],
                    [
                        'label' => 'Офис (помещение, кабинет и пр.)',
                        'attribute' => 'office',
                    ],
                    [
                        'label' => 'Телефон для уведомлений',
                        'attribute' => 'noticePhone',
                    ],
                    [
                        'label' => 'Почта для уведомлений',
                        'attribute' => 'noticeEmail',
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Описание</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($legal->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Контакты</div>
        <div class="card-body">
            Перечень + новые, - старые, динам.виджет
        </div>
    </div>
</div>
