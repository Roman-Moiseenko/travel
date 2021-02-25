<?php


use booking\entities\booking\stays\rules\CheckIn;
use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\rules\Rules;
use booking\entities\booking\stays\Stay;
use Mpdf\Tag\P;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */

$this->title = 'Правила размещения ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилища', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Правила размещения';
?>

<div class="rules">
    <div class="card card-info">
        <div class="card-header">Правила размещения на кроватях</div>
        <div class="card-body">
            <?php if ($stay->rules->beds->child_on): ?>
                <b>Допускается установка дополнительных детских кроватей с 0
                    до <?= $stay->rules->beds->child_agelimit ?>:</b><br>
                - Установка дополнительной детской кровати <?= (int)$stay->rules->beds->child_cost == 0 ? '<span class="badge badge-success">бесплатна</span>' : '<span class="badge badge-info">' . $stay->rules->beds->child_cost . ' руб/сут</span>' ?>
                <br>
                - Допускается установка не более <?= $stay->rules->beds->child_count ?> кроватей <br>
            <?php else: ?>
                <span class="badge badge-warning">Установка дополнительных детских кроватей не допускается</span><br>
            <?php endif; ?>
            <b>Ребенок считается взрослым для размещения на отдельной кровати
                с <?= $stay->rules->beds->child_by_adult ?> лет</b><br>
            <?php if ($stay->rules->beds->adult_on): ?>
                <b>Допускается установка дополнительных кроватей:</b><br>
                - Установка дополнительной кровати <?= (int)$stay->rules->beds->adult_cost == 0 ? '<span class="badge badge-success">бесплатна</span>' : '<span class="badge badge-info">' . $stay->rules->beds->adult_cost . ' руб/сут</span>' ?>
                <br>
                - Допускается установка не более <?= $stay->rules->beds->adult_count ?> кроватей <br>
            <?php else: ?>
                <span class="badge badge-warning">Установка дополнительных кроватей не допускается</span><br>
            <?php endif; ?>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">Парковка</div>
        <div class="card-body">
            <?php if ($stay->rules->parking->is()): ?>
                Гостям предоставляется <span
                        class="badge badge-success"><?= Parking::listPrivate()[$stay->rules->parking->private] ?></span>
                парковка <span
                        class="badge badge-success"><?= Parking::listInside()[$stay->rules->parking->inside] ?></span>
                <br>
                <?= $stay->rules->parking->reserve ? 'Необходимо предварительно бронировать' : '' ?><br>
                <?= $stay->rules->parking->security ? 'Парковка охраняется' : ''?><br>
                <?= $stay->rules->parking->covered ? 'Парковка имеет укрытие от осадков' : ''?><br>
                <?= $stay->rules->parking->street ? 'Парковка расположена на улице' : 'Парковка расположена в здании'?><br>
                <?= $stay->rules->parking->invalid ? 'Имеются места для людей с физическими ограничениями' : ''?><br>
                <?= (int)$stay->rules->parking->status == Rules::STATUS_PAY ? 'Стоимость парковки <u>за ' . Parking::listCost()[$stay->rules->parking->cost_type] . '</u> <span class="badge badge-warning">' . $stay->rules->parking->cost . ' руб. </span>' : ''?>

            <?php else: ?>
                <span class="badge badge-warning">Парковка не предусмотрена</span><br>
            <?php endif; ?>

        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">Правила заселения</div>
        <div class="card-body">
            Заезд гостей возможен с <?= CheckIn::string_time($stay->rules->checkin->checkin_from) ?> до <?= CheckIn::string_time($stay->rules->checkin->checkin_to) ?><br>
            Отъезд гостей возможен с с <?= CheckIn::string_time($stay->rules->checkin->checkout_from) ?> до <?= CheckIn::string_time($stay->rules->checkin->checkout_to) ?><br>
        <?= $stay->rules->checkin->message ? 'Гостям необходимо предварительно сообщить время заезда' : '' ?>

        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">Ограничения</div>
        <div class="card-body">
            <?= $stay->rules->limit->smoking ? 'Разрешается курение в номерах' : '<span class="badge badge-warning">Курение в номерах запрещено</span>' ?>
            <br>
            Размещение с животными <?=
            !$stay->rules->limit->isAnimals() ?
                '<span class="badge badge-warning">не разрешено</span>' :
                ($stay->rules->limit->animals == Rules::STATUS_FREE ?
                    'разрешено' :
                    '<span class="badge badge-info">платно</span>')
            ?><br>
            <?= $stay->rules->limit->children ? 'Разрешено с детьми с ' . $stay->rules->limit->children_allow . ' лет' : 'Заселение с детьми не разрешено!' ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>
