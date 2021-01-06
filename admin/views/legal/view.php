<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $user User */
/* @var $legal Legal */

$this->title = $legal->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-legal">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $legal->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Контакты', ['contacts', 'id' => $legal->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Сертификаты', ['certs', 'id' => $legal->id], ['class' => 'btn btn-info']) ?>

        <?= Html::a('Удалить', ['delete', 'id' => $legal->id], [
            'class' => 'btn btn-danger ml-5',
            'data' => [
                'confirm' => 'Удалить данную организацию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $legal,
                'attributes' => [
                    [
                        'label' => 'ID',
                        'attribute' => 'id',
                    ],
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
                        'label' => 'Заголовок (торговая марка) - EN',
                        'attribute' => 'caption_en',
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
        <div class="card-header with-border">Описание EN</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($legal->description_en, [
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

            <?php foreach ($legal->contactAssignment as $contact): ?>
                <img src="<?= $contact->contact->getThumbFileUrl('photo', 'icon') ?>" title="<?= $contact->value?>"/>
            <?php endforeach; ?>
            <?= Html::a('Редактировать', ['contacts', 'id' => $legal->id], ['class' => 'btn btn-info']) ?>

        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Сертификаты</div>
        <div class="card-body">
            <?php foreach ($legal->certs as $cert): ?>
                <img src="<?= $cert->getThumbFileUrl('file', 'admin') ?>" title="<?= $cert->name?>"/>
            <?php endforeach; ?>
            <?= Html::a('Редактировать', ['certs', 'id' => $legal->id], ['class' => 'btn btn-info']) ?>
        </div>
    </div>
</div>
