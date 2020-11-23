<?php
$this->title = 'Добро пожаловать!';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte3\widgets\Callout::widget([
                'type' => 'info',
                'head' => 'Спасибо, что Вы с нами!',
                'body' => 'Наш проект направлен на объединение всех объектов бронирования для туристов в одном портале. Сейчас проект находится в стадии развития и наполнения информации. <br>
                     На данный момент работает раздел Туры (экскурсии) и прокат Авто.
                     В данный момент идет разработка блока Развлечения, далее будем добавлять бронирование жилья и т.п. <br>
                     Проект должен быть удобный клиентам и функциональным для провайдера. ' .
                    'И наша команда старается учесть все пожелания клиентов и провайдеров, и вносит изменения на сайт. Поэтому, если у Вас есть предложения по развитию или какие-либо недочеты по работе портала, обязательно напишите нам в Службу поддержки. ' .
                    'Или позвоните по телефону ' . \Yii::$app->params['supportPhone']
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte3\widgets\Callout::widget([
                'type' => 'success',
                'head' => 'Стоимость',
                'body' => 'В течение периода развития пользование проектом будет абсолютно бесплатным!<br>
                        Мы не планируем переводить проект на платную основу. Каждый провайдер сам может выбирать, как принимать оплату с клиентов.<br> 
                        Либо принимать лично, и через портал осуществлять только бронирование. В таком случае Вы экономите на комиссии банка и на вознаграждении портала, но и увеличиваете количество отказников по брони,
                        так же уведомления как Вам, так и клиенту будут приходить только на электронную почту.<br>
                        Либо вы можете указать прием оплаты через сайт, тем самым снизив количество отказников и даже доведя их до нуля, путем запрета отмены бронирования. Так же в  этом случае, вы всегда получите СМС об оплате бронирования,
                        а Клиент получит уведомление с пин-кодом на бронирование.<br>
                        Выбрать способ оплаты можно для каждого объекта отдельно. На период наполнения сайта (до подключения Яндекс.Кассы) у всех установлен первый способ.<br>                                            
                        Процент вознаграждения нашему порталу составит ' . \Yii::$app->params['deduction'] .
                    '%. <br>Комиссия платежной системы (Яндекс.Кассы) меняется от оборота и на данный момент составляет ' . \Yii::$app->params['merchant'] .
                    '%. Оплату комиссии можно возложить на клиента (в каждом объекте бронирования настраивается отдельно), но на начальной стадии развития мы не рекомендуем.'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte3\widgets\Callout::widget([
                'type' => 'warning',
                'head' => 'Блог',
                'body' => 'Так же мы развиваем наш блог, который планируем наполнить всей информацией о нашем регионе:<br>
                        всё, что будет интересно нашим гостям, все места, которые они захотят посетить, постараемся осветить.<br>
                        На этапе развития, мы допускаем размещения скрытой рекламы в статьях блога на безвозмездной основе. Надо всего лишь выполнить несложные условия:<br> 
                        1. Статья должна быть интересная, не перегруженная фактами и цифрами.<br>
                        2. Обязательно должна содержать фотографии.<br>
                        3. Тематика должна быть туристического характера.<br> 
                        Например, у Вас имеется антикварная лавка. Напишите захватывающий текст об этом, снабдив свой рассказ фотографиями (сама лавка, предметы антикварные и т.п.).
                        В конце добавив свои контакты и адрес где ее могут посетить туристы.'
            ]) ?>
        </div>
    </div>
</div>