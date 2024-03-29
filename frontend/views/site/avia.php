<?php

use booking\entities\Lang;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $user \booking\entities\user\User|null */
/* @var $region string */

$avia_desc = 'Авиабилеты в Калининград с любого города России по низкой цене можно приобрести у нас без посредников';
$this->registerMetaTag(['name' => 'description', 'content' => $avia_desc]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $avia_desc]);

$this->title = Lang::t('Авиабилеты в Калининград недорогие');
$this->params['breadcrumbs'][] = Lang::t('Авиабилеты в Калининград');
$this->params['canonical'] = Url::to(['/avia'], true);


?>
<h1>Авиабилеты в Калининград</h1>
<div class="params-moving">
    <p class="indent">
        Аэропорт ХРАБРОВО (Калининград) — (IATA: KGD, ICAO: UMKK) международный аэропорт федерального назначения.
        Аэропорт Калининград расположен в 20 км к северо-востоку от центра города рядом с поселком Храброво.
        Аэропорт является крупнейшим узлом, по обслуживанию местных и международных авиалиний.
        На первом и втором этаже терминала международного аэропорта Калининград расположены магазины, банкоматы, кафе,
        комната матери и ребенка, камера хранения, медпункт.
    </p>
</div>
<script src="//tp.media/content?currency=rub&promo_id=4041&shmarker=iddqd&campaign_id=100&trs=133807&searchUrl=www.aviasales.ru%2Fsearch&locale=ru&powered_by=true&one_way=false&only_direct=true&period=year&range=7%2C14&primary=%230C73FE&color_background=%23FFFFFF&achieve=%2345AD35&dark=%23000000&light=%23fffff&destination=<?= $region ?>" charset="utf-8"></script>
<div class="params-moving">
    <h2>Парковки в аэропорту Храброво</h2><p></p>
    <h3>Бесплатная парковка</h3>
    <p class="">Расположена в 400 м от аэровокзала и рассчитана на 200 парковочных мест.</p>
    <h3>Служебная парковка</h3>
    <p class="">
        Служебная парковка предназначена для сотрудников АО «Аэропорт «Храброво» и посетителей грузового терминала,
        имеющих служебные пропуска и соответствующие документы на отправку/получение грузов.
    </p>
    <h3>Парковка перед зданием аэровокзала</h3>
    <p class="">
        Внимание! Парковка на первой линии (привокзальная площадь) запрещена.
        На привокзальную площадь возможен въезд для общественного транспорта и такси, с которыми у аэропорта заключен
        договор, для посадки и высадки пассажиров. Остальным транспортным средствам въезд запрещен.
        Автомобили, поставленные на парковку на привокзальной площади подлежат эвакуации.
    </p>
    <h3>Краткосрочная и долгосрочная платная парковка</h3>
    <p class="">
        Расположены на привокзальной площади аэропорта «Храброво». Первые 15 минут первого часа плата за парковку не взимается.<br>
        Повторный въезд в течение 2 часов тарифицируется с 1-ой минуты въезда.<br>
        Стоимость краткосрочной парковки составляет 150 рублей за каждый полный и неполный час.<br>
        Стоимость долгосрочной парковки составляет 450 рублей за каждые полные и неполные сутки.<br>
        Пассажиры и посетители аэропорта могут оставлять свои автомобили на длительное время на территории платной парковки, расположенной перед зданием аэровокзала.<br>
        Парковочный комплекс аэропорта "Храброво" работает круглосуточно.
    </p>
    <img class="img-responsive" src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/avia/parking_aeroport.jpg'?>" alt="<?= Lang::t('Схема расположения парковок в Храброво')?>">
    <h2 class="pt-4">Расписание автобусов</h2>
        <p><b>Калининград- Аэропорт "Храброво"-Калининград</b></p>
    <p>Автобусный маршрут 244-Э — среднее время в пути 45 минут.</p>
    <div class="row">
        <div class="col-sm-6 col-lg-4">
            <table class="table table-striped">
                <tr>
                    <th>Автовокзал «Южный»</th>
                    <th>Аэропорт «Храброво»</th>
                </tr>
                <tr><td>07:00</td><td>07:45</td></tr>
                <tr><td>07:40</td><td>08:25</td></tr>
                <tr><td>08:20</td><td>09:05</td></tr>
                <tr><td>09:00</td><td>09:45</td></tr>
                <tr><td>09:40</td><td>10:25</td></tr>
                <tr><td>10:20</td><td>11:05</td></tr>
                <tr><td>11:00</td><td>11:45</td></tr>
                <tr><td>11:40</td><td>12:25</td></tr>
                <tr><td>12:20</td><td>13:05</td></tr>
                <tr><td>13:00</td><td>13:45</td></tr>
                <tr><td>13:40</td><td>14:25</td></tr>
                <tr><td>14:20</td><td>15:05</td></tr>
                <tr><td>15:00</td><td>15:45</td></tr>
                <tr><td>15:40</td><td>16:25</td></tr>
                <tr><td>16:20</td><td>17:05</td></tr>
                <tr><td>17:00</td><td>17:45</td></tr>
                <tr><td>17:40</td><td>18:25</td></tr>
                <tr><td>18:20</td><td>19:05</td></tr>
                <tr><td>19:00</td><td>19:45</td></tr>
                <tr><td>19:40</td><td>20:25</td></tr>
                <tr><td>20:20</td><td>21:05</td></tr>
            </table>
        </div>
        <div class="col-sm-6 col-lg-4">
            <table class="table table-striped">
                <tr>
                    <th>Аэропорт «Храброво»</th>
                    <th>Автовокзал «Южный»</th>
                </tr>
                <tr><td>08:30</td><td>09:05</td></tr>
                <tr><td>09:00</td><td>09:45</td></tr>
                <tr><td>09:40</td><td>10:25</td></tr>
                <tr><td>10:20</td><td>11:05</td></tr>
                <tr><td>11:00</td><td>11:45</td></tr>
                <tr><td>11:40</td><td>12:25</td></tr>
                <tr><td>12:20</td><td>13:05</td></tr>
                <tr><td>13:00</td><td>13:45</td></tr>
                <tr><td>13:40</td><td>14:25</td></tr>
                <tr><td>14:20</td><td>15:05</td></tr>
                <tr><td>15:00</td><td>15:45</td></tr>
                <tr><td>15:40</td><td>16:25</td></tr>
                <tr><td>16:20</td><td>17:05</td></tr>
                <tr><td>17:00</td><td>17:45</td></tr>
                <tr><td>17:40</td><td>18:25</td></tr>
                <tr><td>18:20</td><td>19:05</td></tr>
                <tr><td>19:00</td><td>19:45</td></tr>
                <tr><td>19:40</td><td>20:25</td></tr>
                <tr><td>20:20</td><td>21:05</td></tr>
                <tr><td>21:00</td><td>21:45</td></tr>
                <tr><td>22:30</td><td>23:15</td></tr>
            </table>
        </div>

    </div>
</div>