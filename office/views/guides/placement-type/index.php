<?php
/* @var $this yii\web\View */
/* @var $types Type[] */

$this->title = 'Типы проживания';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\booking\tours\Type;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="tour-type-list">
    <p>
        <?= Html::a('Создать Тип', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card adaptive-width-70">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td data-label="ID"><?= $type->id ?></td>
                    <td data-label="Название"><?= $type->name ?></td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $type->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $type->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Тип проживания?',
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