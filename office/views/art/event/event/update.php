<?php

use booking\entities\art\event\Event;
use booking\forms\art\event\EventForm;
use yii\web\View;


/* @var $this View */
/* @var $model EventForm */
/* @var $event Event */

$this->title = 'Создать Событие';

$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['/art/event/event']];
$this->params['breadcrumbs'][] = 'Создать';

 ?>

<?= $this->render('_form', [
    'model' => $model,
    'event' => $event,
]) ?>
