<?php

use booking\entities\moving\agent\Region;
use booking\forms\moving\AgentForm;
use yii\web\View;

/* @var $this View */
/* @var $model AgentForm */
/* @var $region Region */

$this->title = 'Создать Агента';
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $region->name, 'url' => ['view-region', 'id' => $region->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="agent-create">
    <?= $this->render('_form_agent', [
        'model' => $model,
        'agent' => null,
    ]) ?>

</div>

