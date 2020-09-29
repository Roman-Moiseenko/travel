<?php
/* @var $this yii\web\View */
/* @var $contacts Contact[] */
/* @var $contact Contact */

$this->title = 'Типы контактов';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\admin\Contact;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="providers-list">
    <p>
        <?= Html::a('Создать Контакт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card" style="width: 70% !important;">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Рис.</th>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>Префикс (для ссылки)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $contact->id ?></td>
                    <td><img src="<?= $contact->getThumbFileUrl('photo', 'icon') ?>"></td>
                    <td><?= $contact->name ?></td>
                    <td><?= $contact->type == 0 ? '' : 'Да' ?></td>
                    <td><?= $contact->prefix ?></td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $contact->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $contact->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Контакт?',
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