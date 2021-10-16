<?php


/* @var $this \yii\web\View */

use booking\entities\Lang;
use frontend\assets\MovingAsset;
use frontend\widgets\design\BtnUrl;

?>

<div class="container-hr">
    <hr/>
    <div class="text-left-hr"><?= Lang::t('Агентство «Privat-Недвижимость»') ?></div>
</div>

<div class="py-3 landowner-main">
    <p><a href="https://koenigs.ru/realtor">Агентство недвижимости «Privat-Недвижимость»</a> работает на рынке элитной
        загородной и коммерческой недвижимости,
        квартир премиум класса и деликатной покупке-продажи земельных участков, а также организует полный цикл
        строительства
        элитных частных домов под ключ, с привлечением специалистов высокого профессионального уровня в области
        проектирования и дизайна.</p>
    <p>
        Наше Агентство оказывает помощь переезжающим на ПМЖ в Калининград:
    </p>
    <ul>
        <li>Сопровождение и технический надзор за строительством дома и ремонтом квартир</li>
        <li>Помощь в трудоустройстве и решению бытовых вопросов</li>
        <li>Помощь при покупке автомобиля в Калининградской области</li>
    </ul>
    <p>
        Вы можете ознакомиться с <a href="https://koenigs.ru/moving/map" rel="nofollow">нашей дорожной картой для
            переезжающих на ПМЖ</a> и после регистрации на сайте скачать ее по ссылке в конце страницы.
    </p>
    <p>
        <a href="https://koenigs.ru/about" rel="nofollow">Команда проекта "Кёнигс.РУ"</a>
    </p>
    <p>Также Вы можете заказать у нас специальный тур для переезжающих на ПМЖ в Калининградскую область.</p>
</div>

<div class="row">
    <div class="col-lg-4 col-sm-6">
        <?= BtnUrl::widget([
            'url' => 'https://koenigs.ru/moving/tur-dlya-pereezzhayushchih-v-kaliningrad',
            'caption' => 'Тур на ПМЖ в Калининград',
            'block' => false,
        ]) ?>
    </div>
</div>
