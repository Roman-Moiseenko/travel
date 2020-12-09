<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchCarForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\cars\SearchCarForm;
use booking\forms\booking\tours\SearchTourForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = Lang::t('Прокат авто, мото, велосипедов, скутеров');

$js_search = <<<JS
$(document).ready(function() {
    $('body').on('change', '.change-attr', function () {
        let date_from = $('#searchcarform-date_from').val();
        let date_to = $('#searchcarform-date_to').val();
        let city = $('#city').val();
        let type = $(this).val();
        //let value = $(this).attr('value');
        //alert(id);
        $.post("/cars/cars/get-search", {type: type, date_from: date_from, date_to: date_to, city: city}, function (data) {
            //console.log(data);
            $('.block-search-car').html(data);
            //$(".krajee-datepicker").datepicker();
            //initDPRemove('car-range');
            //initDPAddon('car-range');
        });
    });

});
JS;

$this->registerJs($js_search);

$js = <<<JS
    $(document).ready(function() {
       // $('#info').modal('show');
    });
JS;
$this->registerJs($js);
?>

<div class="modal fade" id="info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="staticBackdropLabel"><span
                            class="badge badge-danger"><?= Lang::t('Внимание') ?>!</span></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px; line-height: 2.5;">
                <?= Lang::t('Данный портал находится в стадии наполнения информации, и на данный момент все доступные элементы бронирования доступны либо только для ознакомления, либо являются тестовыми и не несут никаких обязательств по предоставлению услуг.') ?>
                <br><span><?= Lang::t('Если вы предоставляете какие либо услуги по экскурсиями, турам и другим мероприятиям из туризма/отдыха, Вы можете зарегистрироваться на нашем портале по адресу') ?> <a
                            href="http://admin.koenigs.ru" target="_blank">http://admin.koenigs.ru</a></span>
                , <?= Lang::t('либо напишите на почту') ?> <a href="mailto:provider@koenigs.ru" target="_blank">provider@koenigs.ru</a><br>

                <?= Lang::t('После наполнения блоков Туры и Авто будет подключен блок по бронированию Развлечений. Далее - Жилья') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Lang::t('Прочитал') ?></button>
            </div>
        </div>
    </div>
</div>
<div class="list-cars">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-3 p-2">
            <div class="leftbar-search-cars">
                <div class="block-search-car">
            <?= $this->render('_search', ['model' => $model]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>
