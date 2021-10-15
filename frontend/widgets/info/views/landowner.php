<?php


/* @var $this \yii\web\View */

use booking\entities\Lang;
use frontend\widgets\design\BtnMail;
use frontend\widgets\design\BtnUrl;

?>

<div class="container-hr">
    <hr/>
    <div class="text-left-hr"><?= Lang::t('Агентство «Privat-Недвижимость»') ?></div>
</div>

<div>
    Наши услуги<br>
    ссылка на основную страницу
</div>
<div>
    Позвонить
</div>

<div class="row">
    <div class="col-lg-4 col-sm-6">
    <?= BtnUrl::widget([
        'url' => 'https://koenigs.ru/moving/tur-dlya-pereezzhayushchih-v-kaliningrad',
        'caption' => 'Тур на ПМЖ в Калининград',

    ]) ?>
    </div>
</div>
