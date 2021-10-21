<?php

use booking\entities\moving\agent\Agent;
use booking\forms\moving\AgentForm;
use yii\web\View;



/* @var $this View */
/* @var $model AgentForm */
/* @var $agent Agent */

$this->title = 'Редактировать Агента ' . $agent->person->getShortname();
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $agent->region->name, 'url' => ['view-region', 'id' => $agent->region->id]];
$this->params['breadcrumbs'][] = ['label' => $agent->person->getShortname(), 'url' => ['view-agent', 'id' => $agent->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="agent-create">
    <?= $this->render('_form_agent', [
        'model' => $model,
        'agent' => $agent,
    ]) ?>
</div>
