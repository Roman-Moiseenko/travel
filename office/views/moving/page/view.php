<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $page booking\entities\moving\Page */

$this->title = $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $page->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $page->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить страницу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $page,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'title',
                        'format' => 'text',
                        'label' => 'Заголовок'
                    ],
                    [
                        'attribute' => 'slug',
                        'format' => 'text',
                        'label' => 'Ссылка'
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header with-border">Содержимое</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($page->content, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header with-border">Для SEO</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $page,
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
