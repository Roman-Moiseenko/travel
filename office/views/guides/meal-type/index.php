<?php
use booking\entities\booking\Meals;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $types Meals[] */

$this->title = 'Категории питания';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="meal-type-list">
    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card adaptive-width-70">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Маркировка</th>
                    <th>Расшифровка</th>
                    <th>Сортировка</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td data-label="ID"><?= $type->id ?></td>
                    <td data-label="Маркировка"><?= $type->mark ?></td>
                    <td data-label="Расшифровка"><?= $type->name ?></td>
                    <td data-label="Сортировка">
                        <?=
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $type->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $type->id],
                            ['data-method' => 'post',]);
                        ?>
                    </td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $type->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $type->id], [
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