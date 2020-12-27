<?php

use booking\entities\Lang;
use booking\entities\user\User;
use booking\helpers\country\CountryHelper;
use booking\sms\sms;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $user User */

$this->title = Lang::t('Профиль');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-profile">

    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($user->personal->photo)): ?>
            <img src="<?= Html::encode($user->personal->getThumbFileUrl('photo', 'profile')) ?>" alt=""
                 class="img-responsive" style="max-width:100%;height:auto;"/>
            <?php else: ?>
                <img src="<?= Url::to('@static/files/images/no_user.png') ?>" alt=""
                     class="img-responsive" style="max-width:100%;height:auto;"/>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $user->personal,
                'attributes' => [
                    [
                        'attribute' => 'fullname.surname',
                        'label' => Lang::t('Фамилия'),
                    ],
                    [
                        'attribute' => 'fullname.firstname',
                        'label' => Lang::t('Имя'),
                    ],
                    [
                        'attribute' => 'fullname.secondname',
                        'label' => Lang::t('Отчество'),
                    ],
                    [
                        'attribute' => 'dateborn',
                        'value' => $user->personal->dateborn ? date('d-m-Y', $user->personal->dateborn) : '',
                        'label' => Lang::t('Дата рождения'),
                    ],
                    [
                        'attribute' => 'phone',
                        'label' => Lang::t('Телефон'),
                    ],
                    [
                        'attribute' => 'address.country',
                        'value' => CountryHelper::name($user->personal->address->country),
                        'label' => Lang::t('Страна'),
                    ],
                    [
                        'attribute' => 'address.index',
                        'label' => Lang::t('Индекс'),
                    ],
                    [
                        'attribute' => 'address.town',
                        'label' => Lang::t('Город'),
                    ],
                    [
                        'attribute' => 'address.address',
                        'label' => Lang::t('Адрес'),
                    ],
                ],
            ]); ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::a(Lang::t('Редактировать'), Url::to(['/cabinet/profile/update', 'id' => $user->id]), ['class' => 'btn-lg btn-primary']) ?>
    </div>
</div>
