<?php
/* @var $this yii\web\View */
/* @var $categories CategoryFAQ[] */

$this->title = 'Категории Вопросов';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\tours\Type;
use booking\entities\moving\CategoryFAQ;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="tour-type-list">
    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card adaptive-width-70">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>Сортировка</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td data-label="ID"><?= $category->id ?></td>
                    <td data-label="Заголовок"><?= $category->caption ?></td>
                    <td data-label="Описание"><?= $category->description ?></td>
                    <td data-label="Сортировка">
                        <?=
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $category->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $category->id],
                            ['data-method' => 'post',]);
                        ?>
                    </td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $category->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $category->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Категорию?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>