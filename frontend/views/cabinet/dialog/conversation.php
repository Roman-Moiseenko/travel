<?php

use booking\entities\Lang;
use booking\entities\message\Dialog;
use yii\helpers\Url;

/* @var $dialog Dialog */

$this->title = Lang::t('Переписка');
$this->params['breadcrumbs'][] = ['label' => Lang::t('Сообщения'), 'url' => Url::to(['cabinet/dialog/index'])];;
$this->params['breadcrumbs'][] = $this->title;
?>
