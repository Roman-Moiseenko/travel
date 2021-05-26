<?php

use booking\entities\moving\Page;
use booking\entities\survey\Survey;
use booking\helpers\StatusHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $survey Survey */


$this->title = 'Вопросы к опросу';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => Url::to(['/moving/survey'])];
$this->params['breadcrumbs'][] = ['label' => $survey->caption, 'url' => Url::to(['/moving/survey/view', 'id' => $survey->id])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">
    <p>
        <?= Html::a('Создать Вопрос', ['create', 'id' => $survey->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card-body">
        <table class="table table-adaptive table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Вопрос</th>
                <th>Сортировка</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($survey->questions as $question): ?>
                <tr>
                    <td data-label="ID"><?= $question->id ?></td>
                    <td data-label="Вопрос"><?= $question->question ?></td>
                    <td data-label="Сортировка">
                        <?=
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $question->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $question->id],
                            ['data-method' => 'post',]);
                        ?>
                    </td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $question->id]) ?>"><span
                                    class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $question->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Вопрос?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        <div class="pl-2">
                            <table  class="table table-adaptive table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Вариант ответа</th>
                                    <th>Сортировка</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($question->variants as $variant): ?>
                                    <tr>
                                        <td data-label="ID"><?= $variant->id ?></td>
                                        <td data-label="Вариант"><?= $variant->text ?></td>
                                        <td data-label="Сортировка">
                                            <?=
                                            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up-variant', 'id' => $variant->id],
                                                ['data-method' => 'post',]) .
                                            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down-variant', 'id' => $variant->id],
                                                ['data-method' => 'post',]);
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?= Url::to(['update-variant', 'id' => $variant->id]) ?>"><span
                                                        class="glyphicon glyphicon-pencil"></span></a>
                                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-variant', 'id' => $variant->id], [
                                                'data' => [
                                                    'confirm' => 'Вы уверены что хотите удалить Вариант ответа?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= Html::a('Добавить Вариант', ['create-variant', 'id' => $question->id], ['class' => 'btn btn-info']) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>