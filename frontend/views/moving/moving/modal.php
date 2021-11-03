<?php


/* @var $this \yii\web\View */

/* @var $modal_id string */


use frontend\widgets\design\BtnMail;
use frontend\widgets\design\BtnSend;
use yii\bootstrap4\Modal; ?>

<?php Modal::begin([
    'title' => 'Тестируем Функционал, отнеситесь с пониманием ;)',
    'clientOptions' => ['show' => true],
    'size' => Modal::SIZE_LARGE,
    'centerVertical' => true,
    'headerOptions' => [
        'class' => 'modal-widget modal-widget-header moving-anketa ',
    ],
    'bodyOptions' => [
        'class' => 'modal-widget modal-widget-body moving-anketa',
        'style' => 'border-radius: 80 px;'
    ],
]) ?>

    <div class="row">
        <div class="col-sm-6">
            <img src="https://static.koenigs.ru/images/moving/modal/moving_anketa_1.jpg" class="img-responsive"
                 />
        </div>
        <div class="col-sm-6 d-flex">
            <div>
                Текст
            </div>
            <div class="mt-auto mb-4">
                <?= BtnMail::widget([
                    'caption' => 'Заполнить Анкету',
                    'url' => 'https://forms.gle/4nSC893icsomkYyz9',
                ]) ?>
            </div>
        </div>
    </div>


<?php Modal::end() ?>