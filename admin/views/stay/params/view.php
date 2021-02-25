<?php

use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\StayParams;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */

$this->title = 'Параметры ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Параметры';

?>

<div class="params-stay">
    <div class="card card-info">
        <div class="card-header">Параметры</div>
        <div class="card-body">
            <?= (int)$stay->params->count_bath == 0 ? 'Ванные комнаты не предусмотрены' : 'В жилом помещении <span class="badge badge-primary">' . $stay->params->count_bath . '</span> ванных комнат'?><br>
            <?= (int)$stay->params->count_kitchen == 0 ? 'Кухня не предусмотрена' : 'В жилом помещении <span class="badge badge-primary">' . $stay->params->count_kitchen . '</span> кухонь'?><br>
            Общая площадь жилого помещения <span class="badge badge-primary"><?= $stay->params->square ?></span> кв.м.<br>
            Предусмотрено размещение не более <span class="badge badge-primary"><?= $stay->params->guest ?></span> гостей<br>
            <?= (int)$stay->params->count_floor > 0 ? 'В доме <span class="badge badge-primary">' . $stay->params->count_floor . '</span> этажей': ''?><br>
            <?= (int)$stay->params->deposit > 0 ? 'Необходим страховой залог в размере <span class="badge badge-primary">' . $stay->params->deposit . '</span> руб.': 'Залог не требуется'?><br>
            <span class="badge badge-success"><?= $stay->params->access ? StayParams::listAccess()[$stay->params->access] : '' ?></span><br>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>