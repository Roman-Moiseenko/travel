<?php

use booking\entities\Lang;
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
            <div class="col-12">
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
</div>
