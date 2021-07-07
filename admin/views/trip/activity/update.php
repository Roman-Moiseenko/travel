<?php

use booking\entities\booking\trips\activity\Activity;



/* @var $this \yii\web\View */
/* @var $trip \booking\entities\booking\trips\Trip|null */
/* @var $activity Activity*/
$this->title = 'Создать мероприятие ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Мероприятия', 'url' => ['/trip/activity', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Создать';
?>

<?= $this->render('_form', [
    'model' => $model,
    'trip' => $trip,
    'activity' => $activity,
])?>
