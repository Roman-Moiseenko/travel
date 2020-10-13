<?php

use booking\entities\admin\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $user User */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-profile">
    <div class="card card-default">
        <div class="card-header with-border"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= Html::encode($user->personal->getThumbFileUrl('photo', 'profile')) ?>" alt=""
                         class="img-responsive"/>
                </div>
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $user->personal,
                        'attributes' => [
                            [
                                'attribute' => 'fullname.surname',
                                'label' => 'Фамилия',
                            ],
                            [
                                'attribute' => 'fullname.firstname',
                                'label' => 'Имя',
                            ],
                            [
                                'attribute' => 'fullname.secondname',
                                'label' => 'Отчество',
                            ],
                            [
                                'attribute' => 'dateborn',
                                'value' => $user->personal->dateborn ? date('d-m-Y', $user->personal->dateborn) : '',
                                'label' => 'Дата рождения',
                            ],
                            [
                                'attribute' => 'phone',
                                'label' => 'Телефон',
                            ],
                            [
                                'attribute' => 'address.index',
                                'label' => 'Индекс',
                            ],
                            [
                                'attribute' => 'address.town',
                                'label' => 'Город',
                            ],
                            [
                                'attribute' => 'address.address',
                                'label' => 'Адрес',
                            ],
                            [
                                'attribute' => 'position',
                                'label' => 'Должность',
                            ],
                        ],
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/cabinet/profile/update',]), ['class' => 'btn btn-success']) ?>
    </div>

</div>

