<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $trip \booking\entities\booking\trips\Trip|null */
$this->title = 'Мероприятия ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Мероприятия';



?>
<p>
    <?= Html::a('Создать мероприятие', Url::to(['trip/activity/create', 'id' => $trip->id]), ['class' => 'btn btn-success']) ?>
</p>


<?php if ($trip->filling) {
    echo Html::a('Далее >>', Url::to(['filling', 'id' => $trip->id]), ['class' => 'btn btn-primary']);
}
?>