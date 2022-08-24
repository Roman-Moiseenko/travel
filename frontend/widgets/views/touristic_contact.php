<?php

use booking\entities\touristic\TouristicContact;
use frontend\widgets\design\BtnMail;
use frontend\widgets\design\BtnPhone;
use frontend\widgets\design\BtnUrl;

/* @var $contact TouristicContact */
/* @var $block boolean */
/* @var $fun_id integer */

$array = [];

if (!empty($contact->phone)) $array[] = BtnPhone::widget([
    'phone' => $contact->phone,
    'caption' => 'Позвонить',
    'block' => true,
    'class_name_click' => \booking\entities\touristic\fun\Fun::class,
    'class_id_click' => $fun_id,
    ]);

if (!empty($contact->url)) $array[] = BtnUrl::widget([
    'url' => 'https://koenigs.ru/out-link?link=' . $contact->url,
    'caption' => 'Перейти на сайт',
    'block' => true,
    'class_name_click' => \booking\entities\touristic\fun\Fun::class,
    'class_id_click' => $fun_id,
]);
if (!empty($contact->email)) $array[] = BtnMail::widget([
    'url' => 'mailto:' . $contact->email,
    'caption' => 'Написать письмо',
    'block' => true,
    'class_name_click' => \booking\entities\touristic\fun\Fun::class,
    'class_id_click' => $fun_id,
]);
?>


<div class="row pt-4">
    <?php foreach ($array as $i => $item):?>
    <div class="col-sm-4 py-1">
        <?= $array[$i] ?>
    </div>
    <?php endforeach; ?>
</div>