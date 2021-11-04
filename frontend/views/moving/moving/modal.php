<?php


/* @var $this \yii\web\View */

/* @var $modal_id string */


use frontend\widgets\design\BtnMail;
use frontend\widgets\design\BtnSend;
use yii\bootstrap4\Modal; ?>

<?php Modal::begin([
    'title' => 'Здравствуй, уважаемый посетитель нашего портала!',
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
        <div class="col-md-6 col-sm-12">
            <img src="https://static.koenigs.ru/images/moving/modal/moving_anketa_1.jpg" class="img-responsive"
            />
        </div>
        <div class="col-md-6 col-sm-12 d-flex flex-column">
                <div>
                    <div  class="params-modal">
                    <p>Мы заметили, что возможно:</p>
                    <ul>
                        <li>Вам интересна тема переезда на ПМЖ в Калининград</li>
                        <li>Вы планируете в ближайшее время посетить Калининград, чтоб оценить
                            возможность переезда
                        </li>
                        <!--li>Вы уже решились переехать в Калининград</li-->
                    </ul>
                    <p>Но, есть трудности, которые Вы пока не знаете, как их преодолеть.</p>
                    <p class="pt-2" style="font-weight: 600">Заполните нашу анкету, и мы поможем Вам. А также Вы получите от нас подарок - Памятку о переезда на ПМЖ!</p>
                    </div>
                </div>
                <div class="mt-auto mb-4">
                    <?= BtnSend::widget([
                        'caption' => 'Заполнить Анкету',
                        'url' => 'https://forms.gle/4nSC893icsomkYyz9',
                    ]) ?>
                </div>

        </div>
    </div>


<?php Modal::end() ?>