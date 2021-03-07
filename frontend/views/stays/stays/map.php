<?php

use booking\entities\booking\stays\Stay;

/* @var $this yii\web\View */
/* @var $stay Stay */

use booking\entities\Lang;
use frontend\assets\MapStayAsset;


MapStayAsset::register($this);
//$this->render($js);
?>
<div id="map-stay" data-zoom="16" data-longitude="<?= $stay->address->longitude ?>" data-latitude="<?= $stay->address->latitude ?>" style="width: 100%; height: 100px"></div>
