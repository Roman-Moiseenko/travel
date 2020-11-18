<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\helpers\BookingHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $user User */
/* @var $objects array */

$this->title = $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$js = <<<JS
$(document).on('click', '.check-object', function() {
  let _status = $(this).is(':checked');  
  let _id = $(this).data('id');
  let _type = $(this).data('type');
  let _user_id = $user->id;
  console.log(_status);
  $.post('/staff/update-object/',
                {user_id: _user_id, type: _type, object_id: _id, status: _status},
                function (data) {
      console.log(data);
                });
})
JS;

$this->registerJs($js);
?>
<div class="staff-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($user->isActive()) {
            echo Html::a('Заблокировать', ['lock', 'id' => $user->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Заблокировать доступ сотруднику?',
                    'method' => 'post',
                ],
            ]);
        } else {
            echo Html::a('Разблокировать', ['unlock', 'id' => $user->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Разблокировать доступ сотруднику?',
                    'method' => 'post',
                ],
            ]);
        }?>
    </p>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $user,
                'attributes' => [
                    [
                        'label' => 'Логин',
                        'attribute' => 'username',
                    ],
                    [
                        'label' => 'ФИО',
                        'attribute' => 'fullname',
                    ],
                    [
                        'label' => 'Касса/Точка продаж',
                        'attribute' => 'box_office',
                    ],
                    [
                        'label' => 'Телефон',
                        'attribute' => 'phone',
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Доступные объекты</div>
        <div class="card-body">
            <table class="table table-adaptive table-striped">
                <tbody class="">
                <?php foreach ($objects as $i => $object): ?>
                    <tr>
                        <td data-label="" width="20px">
                            <input type="checkbox" id="check-<?=$i?>" class="check-object" <?= $object['check'] ? 'checked' : '' ?> data-type="<?= $object['type']?>" data-id="<?= $object['id']?>">
                        </td>
                        <td data-label="" width="60px">
                            <?= BookingHelper::icons($object['type']); ?>
                        </td>
                        <td data-label="Объект">
                                <?= $object['name']?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
