<?php

use booking\entities\shops\AdShop;
use booking\forms\shops\ShopAdCreateForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\shops\ShopTypeHelper;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ShopAdCreateForm */
/* @var $shop Shop */

$js = <<<JS
$(document).ready(function() {
    $('body').on('change', '.work-mode-begin', function () {
        for (let i = 0; i < 7; i++){
            if ($('#workmodeform-' + i + '-day_begin').val() === '') $('#workmodeform-' + i + '-day_begin').val($(this).val());
        }
    });
    $('body').on('change', '.work-mode-end', function () {
        for (let i = 0; i < 7; i++){
            if ($('#workmodeform-' + i + '-day_end').val() === '') $('#workmodeform-' + i + '-day_end').val($(this).val());
        }
    });
    $('body').on('change', '.work-mode-break-begin', function () {
        for (let i = 0; i < 7; i++){
            if ($('#workmodeform-' + i + '-break_begin').val() === '') $('#workmodeform-' + i + '-break_begin').val($(this).val());
        }
    });
    $('body').on('change', '.work-mode-break-end', function () {
        for (let i = 0; i < 7; i++){
            if ($('#workmodeform-' + i + '-break_end').val() === '') $('#workmodeform-' + i + '-break_end').val($(this).val());
        }
    });    
});
JS;
$this->registerJs($js);


?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false,
]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'type_id')->dropDownList(ShopTypeHelper::list(), ['prompt' => ''])->label('Тип магазина') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название магазина') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название магазина (En)') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)') ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Фото</div>
        <div class="card-body">
            <label>Прежде, чем удалять или смещать позицию фотографий, сохраните внесенные изменения!</label>
            <?php if ($shop): ?>
                <div class="row">
                    <?php foreach ($shop->photos as $photo): ?>
                        <div class="col-md-2 col-xs-3" style="text-align: center">
                            <div class="btn-group">
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $shop->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]); ?>
                                <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $shop->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Remove photo?',
                                ]); ?>
                                <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $shop->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                ]); ?>
                            </div>
                            <div>
                                <?= Html::a(
                                    Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                    $photo->getUploadedFileUrl('file'),
                                    ['class' => 'thumbnail', 'target' => '_blank']
                                ) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

            <?= $form->field($model->photos, 'files[]')
                ->label(false)
                ->widget(FileInput::class, [
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['jpg', 'jpeg'],
                    ],
                ]) ?>


        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Режим работы/Контакты</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table>
                        <tr>
                            <th width="20px">
                            </th>
                            <th colspan="2">
                                <b>Режим дня</b>
                            </th>
                            <th colspan="2">
                                <b>Обед</b>
                            </th>
                        </tr>
                        <?php foreach ($model->workModes as $i => $mode): ?>
                            <tr>
                                <td>
                                    <?= WorkModeHelper::week($i) ?>
                                </td>
                                <td width="50px">
                                    <?= $form->field($mode, '[' . $i . ']day_begin')->textInput(['type' => 'time', 'class' => 'work-mode-begin form-control'])->label(false) ?>
                                </td>
                                <td width="50px">
                                    <?= $form->field($mode, '[' . $i . ']day_end')->textInput(['type' => 'time', 'class' => 'work-mode-end form-control'])->label(false) ?>
                                </td>
                                <td width="50px">
                                    <?= $form->field($mode, '[' . $i . ']break_begin')->textInput(['type' => 'time', 'class' => 'work-mode-break-begin form-control'])->label(false) ?>
                                </td>
                                <td width="50px">
                                    <?= $form->field($mode, '[' . $i . ']break_end')->textInput(['type' => 'time', 'class' => 'work-mode-break-end form-control'])->label(false) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-2"><label>Соц.сеть</label></div>
                        <div class="col-4"><label>Значение</label></div>
                        <div class="col-4"><label>Описание</label></div>
                    </div>
                    <?php foreach ($model->contactAssign as $i => $assignForm): ?>
                        <div class="row">
                            <div class="col-2"><img src="<?= $assignForm->_contact->getThumbFileUrl('photo', 'icon') ?>"></div>
                            <div class="col-4"><?= $form->field($assignForm, '[' . $i . ']value')->textInput()->label(false) ?></div>
                            <div class="col-4"><?= $form->field($assignForm, '[' . $i . ']description')->textInput()->label(false) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Адреса Магазинов</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div id="map-shop-ad" style="width: 100%; height: 500px"></div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-7"><label>Адрес</label></div>
                        <div class="col-5"><label>Телефон</label></div>
                    </div>
                    <div id="map-points" data-count="<?= $shop ? count($shop->addresses) : 0 ?>">
                        <?php if ($shop): ?>
                            <?php foreach ($shop->addresses as $i => $address): ?>
                                <div class="row">
                                    <div class="col-7">
                                        <input name="AdInfoAddressForm[<?= ($i + 1) ?>][address]"
                                               class="form-control" width="100%" value="<?= $address->address ?>"
                                               id="address-<?= ($i + 1) ?>"
                                               readonly>
                                    </div>
                                    <div class="col-4">
                                        <input name="AdInfoAddressForm[<?= ($i + 1) ?>][phone]"
                                               class="form-control" width="100%" value="<?= $address->phone ?>"
                                               id="phone-<?= ($i + 1) ?>">
                                    </div>
                                    <div class="col-1">
                                        <?php if (count($shop->addresses) == $i + 1): ?>
                                            <span class="glyphicon glyphicon-trash" style="cursor: pointer"
                                                  id="remove-points"></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-1">
                                        <input name="AdInfoAddressForm[<?= ($i + 1) ?>][longitude]"
                                               class="form-control" width="100%" value="<?= $address->longitude ?>"
                                               id="longitude-<?= ($i + 1) ?>"
                                               type="hidden">
                                        <input name="AdInfoAddressForm[<?= ($i + 1) ?>][latitude]"
                                               class="form-control" width="100%" value="<?= $address->latitude ?>"
                                               id="latitude-<?= ($i + 1) ?>"
                                               type="hidden">
                                        <input name="AdInfoAddressForm[<?= ($i + 1) ?>][city]"
                                               class="form-control" width="100%" value="<?= $address->city ?>"
                                               id="city-<?= ($i + 1) ?>"
                                               type="hidden">
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>