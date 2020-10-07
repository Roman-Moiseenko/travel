<?php
/* @var $this yii\web\View */
/* @var $types Type[] */

$this->title = 'Категории туров';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\tours\Type;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="providers-list">
    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card" style="width: 70% !important;">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>Сортировка</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td><?= $type->id ?></td>
                    <td><?= $type->name ?></td>
                    <td><?= $type->slug ?></td>
                    <td>
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