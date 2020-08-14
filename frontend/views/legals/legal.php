<?php

use booking\entities\admin\user\UserLegal;
use yii\helpers\Url;

/* @var $legal UserLegal */

$this->title = $legal->name;
$this->params['breadcrumbs'][] = $this->title;
?>

Сведения о компании
<?= $legal->name ?>
