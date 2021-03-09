<?php

use booking\entities\booking\stays\Stay;

/* @var $this yii\web\View */
/* @var $stay Stay */
/* @var $SearchStayForm array */

use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\assets\AppAsset;
use frontend\assets\MapStayAsset;

//AppAsset::register($this);
MapStayAsset::register($this);
//$this->render($js);
?>
<div id="data-stay"
     data-id="<?= $stay->id ?>"
     data-date-from="<?= $SearchStayForm['date_from']?>"
     data-date-to="<?= $SearchStayForm['date_to']?>"
     data-guest="<?= $SearchStayForm['guest']?>"
     data-children="<?= $SearchStayForm['children']?>"
     data-children-age1="<?= $SearchStayForm['children_age'][1]?>"
     data-children-age2="<?= $SearchStayForm['children_age'][2]?>"
     data-children-age3="<?= $SearchStayForm['children_age'][3]?>"
     data-children-age4="<?= $SearchStayForm['children_age'][4]?>"
     data-children-age5="<?= $SearchStayForm['children_age'][5]?>"
     data-children-age6="<?= $SearchStayForm['children_age'][6]?>"
     data-children-age7="<?= $SearchStayForm['children_age'][7]?>"
     data-children-age8="<?= $SearchStayForm['children_age'][8]?>"
></div>
<div id="map-stay"
     data-zoom="16"
     data-longitude="<?= $stay->address->longitude ?>"
     data-latitude="<?= $stay->address->latitude ?>"
     data-name="<?= $stay->getName() ?>"
     data-cost="<?= ($cost = $stay->costBySearchParams($SearchStayForm)) < 0 ? '' : CurrencyHelper::stat($cost)?>"
     
     style="width: 100%; height: 100px"
></div>