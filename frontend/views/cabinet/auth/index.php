<?php

use booking\entities\Lang;
use booking\helpers\UserHelper;
use frontend\widgets\design\BtnEdit;
use Mpdf\Tag\Li;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use booking\entities\user\User;

/* @var $user User */
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

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
                    'label' => Lang::t('Логин (номер телефона)'),
                ],
                [
                    'attribute' => 'email',
                    'label' => Lang::t('Электронная почта'),
                ],
            ],
        ]); ?>
    </div>
    <div class="form-group">
        <?= BtnEdit::widget(['url' => Url::to(['/cabinet/auth/update',])]) ?>
    </div>
    <?php if (count($user->networks) > 0): ?>
        <h3><?= Lang::t('Привязка к социальным сетям') ?></h3>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><?= Lang::t('Социальная сеть') ?></th>
                <th><?= Lang::t('Идентификатор') ?></th>
                <th width="50px"><?= Lang::t('Отвязать') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($user->networks as $network): ?>
                <tr>
                    <td><?= UserHelper::iconNetwork($network->network) ?></td>
                    <td><?= $network->identity ?></td>
                    <td><?= Html::a('<i class="fas fa-unlink"></i>',
                            '/cabinet/network/disconnect?network=' . $network->network . '&identity=' . $network->identity,
                            [
                                'data' => [
                                    'confirm' => Lang::t('Отсоединить социальную сеть') . ' ' . $network->network . '?',
                                    'method' => 'get',
                                ],
                            ],
                            ) ?></td>
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
