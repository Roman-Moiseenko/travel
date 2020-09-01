<?php

$this->title = 'Бронирования по ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>

Показать ближащие бронирования:<br>
Дата 1. <br>
 . . Время. Кол-во билетов. Сумма <br>
 . . . . Список Туристов - Ф.И.О. Кол-во билетов. Сумма<br>
 . . . . Написать сообщение. № телефона.<br>

...<br>
Дата N. <br>