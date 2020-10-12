<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchTourForm */
/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = Lang::t('Туры, экскурсии, мероприятия');

$js = <<<JS
    $(document).ready(function() {
        $('#info').modal('show');
    });
JS;
$this->registerJs($js);
?>

<div class="modal fade" id="info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="staticBackdropLabel"><span class="badge badge-danger">Внимание!</span></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px; line-height: 2.5;">

                Данный портал находится в стадии наполнения информации, и на данный момент все доступные элементы бронирования доступны либо только для ознакомления, либо являются тестовыми и не несут никаких обязательств по предоставлению услуг.
                <br><span>Если вы предоставляете какие либо услуги по экскурсиями, турам и другим мероприятиям из туризма/отдыха, Вы можете зарегистрироваться на нашем портале по адресу <a href="http://admin.koenigs.ru" target="_blank">http://admin.koenigs.ru</a></span>
                , либо напишите на почту <a href="mailto:r.a.moiseenko@gmail.com" target="_blank">r.a.moiseenko@gmail.com</a><br>

                После наполнения блока "Туры" будут подключены блоки по бронированию Авто и Жилья.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Прочитал</button>
            </div>
        </div>
    </div>
</div>
<div class="site-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search_top', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>
