<?php

use booking\helpers\UserForumHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this \yii\web\View */
/* @var $user \booking\entities\user\User */

$id = $user->id;
$js = <<<JS
$(document).ready(function() {
    let user_id = $id;
    $('body').on('change', '#set-forum-role', function () {
        let role = $(this).val();
        $.post("/clients/forum", {role: role, user_id: user_id},
            function (data) {
            console.log(data);
            }
        );  
    });
});
JS;
$this->registerJs($js);

$this->title = 'Клиент: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $user->username;
?>

<div class="user-view">
    <div class="form-group">

        <label for="set-forum-role"> Доступ на форуме: </label>
        <select class="form-control" id="set-forum-role" style="display: inline !important; width: auto !important;">
            <?php foreach (UserForumHelper::listStatus() as $code => $status): ?>
                <option value="<?= $code ?>" <?= $code == $user->preferences->forum_role ? 'selected' : '' ?>><?= $status ?></option>
            <?php endforeach; ?>
        </select>

    </div>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $user,
                'attributes' => [
                    [
                        'attribute' => 'id',
                    ],
                    [
                        'attribute' => 'username',
                        'format' => 'text',
                        'label' => 'Логин'
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'label' => 'Почта'
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан'
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'datetime',
                        'label' => 'Изменен'
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $user,
                'attributes' => [
                    [
                        'value' => $user->personal->fullname->getFullname(),
                        'label' => 'ФИО'
                    ],
                    [
                        'value' => $user->personal->phone,
                        'label' => 'Телефон'
                    ],
                    [
                        'value' => $user->personal->address->getAddress(),
                        'label' => 'Адрес'
                    ],
                    [
                        'value' => date('d-m-Y', $user->personal->dateborn),
                        'label' => 'Дата рождения'
                    ],

                ],
            ]) ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Покупки</div>
        <div class="card-body">

        </div>
    </div>

</div>
