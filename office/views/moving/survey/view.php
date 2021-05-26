<?php

use booking\entities\survey\Survey;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $survey Survey */

$this->title = $survey->caption;
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $survey->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $survey->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить опрос?',
                'method' => 'post',
            ],
        ]) ?>

        <?php if (!$survey->isActive()) {
            echo Html::a('Активировать', ['activate', 'id' => $survey->id], ['class' => 'btn btn-warning']);
        } else {
            echo Html::a('В черновик', ['draft', 'id' => $survey->id], ['class' => 'btn btn-secondary']);
        } ?>

        <?= Html::a('Вопросы', ['/moving/question', 'id' => $survey->id], ['class' => 'btn btn-success']) ?>

    </p>

    <div class="card">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $survey,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'caption',
                        'format' => 'text',
                        'label' => 'Заголовок'
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header with-border">Вопросы</div>
        <div class="card-body">
            <?php foreach ($survey->questions as $question): ?>
             <div class="pl-2">
                 <b><?= $question->question ?></b>
                 <?php foreach ($question->variants as $variant): ?>
                  <div class="pl-2">
                      <?= $variant->text ?>
                  </div>
                 <?php endforeach; ?>
             </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header with-border">Для SEO</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $survey,
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
