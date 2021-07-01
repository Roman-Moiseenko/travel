<?php

use booking\entities\forum\Category;
use booking\entities\forum\Section;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $categories Category[] */
/* @var $sections Section[] */

$this->title = 'Категории Форума';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="providers-list">
    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php foreach ($sections as $section): ?>
    <div class="card adaptive-width-70 pt-2 card-secondary">
        <div class="card-header"><?= $section->caption ?></div>
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
                <?php if ($category->section_id == $section->id):?>
                    <tr>
                    <td data-label="ID"><?= $category->id ?></td>
                    <td data-label="Название"><?= $category->name ?></td>
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
                <?php endif ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
</div>