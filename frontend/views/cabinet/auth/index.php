<?php

use booking\entities\Lang;
use booking\helpers\UserHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use booking\entities\user\User;

/* @var $user User */

$this->title = Lang::t('Аутентификация');
$this->params['breadcrumbs'][] = ['label' => Lang::t('Профиль'), 'url' => Url::to(['/cabinet/profile'])];;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-auth">
    <div class="col-12 m-0 p-0">
        <?= DetailView::widget([
            'model' => $user,
            'attributes' => [
                [
                    'attribute' => 'username',
                    'label' => Lang::t('Логин'),
                ],
                [
                    'attribute' => 'email',
                    'label' => Lang::t('Электронная почта'),
                ],
            ],
        ]); ?>
    </div>
    <div class="form-group">
        <?= Html::a(Lang::t('Редактировать'), Url::to(['/cabinet/auth/update',]), ['class' => 'btn btn-success']) ?>
    </div>
    <?php if (count($user->networks) > 0): ?>
        <h3><?= Lang::t('Привязка к социальным сетям') ?></h3>
    <table class="table table-adaptive table-striped table-bordered">
        <thead>
        <tr>
            <th><?= Lang::t('Соц.сеть') ?></th>
            <th><?= Lang::t('Идентификатор') ?></th>
            <th><?= Lang::t('Отвязать') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($user->networks as $network): ?>
            <tr>
                <td><?= UserHelper::iconNetwork($network->network) ?></td>
                <td><?= $network->identity ?></td>
                <td><?= Html::a('<i class="fas fa-unlink"></i>', '/cabinet/network/disconnect?network=' . $network->network . '&identity=' . $network->identity) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <h3><?= Lang::t('Привязать профиль из социальных сетей') ?></h3>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>
