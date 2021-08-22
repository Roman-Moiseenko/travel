<?php


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\admin\PasswordEditForm;
use frontend\widgets\design\BtnSave;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model PasswordEditForm */
/* @var $user User */
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->title = 'Изменить Пароль';
$this->params['breadcrumbs'][] = ['label' => 'Аутентификация', 'url' => Url::to(['/cabinet/auth'])];
$this->params['breadcrumbs'][] = ['label' => Lang::t('Профиль'), 'url' => Url::to(['/cabinet/profile'])];;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Новый пароль</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'password')->passwordInput()->label('Новый пароль'); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'password2')->passwordInput()->label('Повторите пароль'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= BtnSave::widget() ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
