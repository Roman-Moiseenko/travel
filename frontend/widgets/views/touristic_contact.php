<?php

use booking\entities\touristic\TouristicContact;
use frontend\widgets\design\BtnMail;
use frontend\widgets\design\BtnPhone;
use frontend\widgets\design\BtnUrl;

/* @var $contact TouristicContact */
/* @var $block boolean */

$array = [];

if (!empty($contact->phone)) $array[] = BtnPhone::widget([
    'phone' => $contact->phone,
    'caption' => 'Позвонить',
    'block' => true]);

if (!empty($contact->url)) $array[] = BtnUrl::widget([
    'url' => $contact->url,
    'caption' => 'Перейти на сайт',
    'block' => true]);
if (!empty($contact->email)) $array[] = BtnMail::widget([
    'url' => $contact->url,
    'caption' => 'Написать письмо',
    'block' => true]);
?>


<div class="row pt-4">
    <?php foreach ($array as $i => $item):?>
    <div class="col-sm-4 py-1">
        <?= $array[$i] ?>
    </div>
    <?php endforeach; ?>
</div>