<?php
declare(strict_types=1);

use booking\entities\Lang;
use booking\entities\office\User;
use booking\forms\office\UserForm;
use booking\helpers\OfficeUserHelper;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model UserForm */
/* @var $new_user bool */
/* @var $user User */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'email')->textInput()->label('Почта') ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'password')->textInput()->label('Пароль')->hint($new_user ? '' : 'Оставьте пустым, если не хотите менять.') ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'role')->dropDownList(OfficeUserHelper::rolesList(), ['prompt' => ''])->label('Уровень доступа') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <?= $form->field($model->person, 'surname')->textInput()->label('Фамилия') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model->person, 'firstname')->textInput()->label('Имя') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model->person, 'secondname')->textInput()->label('Отчество') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'description')->textarea(['rows' => 10])->label('Описание') ?>
                    <?= $form->field($model, 'home_page')->textInput()->label('Ссылка') ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                        'language' => Lang::current(),
                        'bsVersion' => '4.x',
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'initialPreview' => [
                                $user ? $user->getThumbFileUrl('photo', 'profile') : null,
                            ],
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => true,
                            'showRemove' => false,
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>