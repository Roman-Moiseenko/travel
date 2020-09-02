<?php

$this->title = 'Бронирования по ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tours/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Бронирования';
?>

Показать ближащие бронирования:<br>
Дата 1. <br>
 . . Время. Кол-во билетов. Сумма <br>
 . . . . Список Туристов - Ф.И.О. Кол-во билетов. Сумма<br>
 . . . . Написать сообщение. № телефона.<br>

...<br>
Дата N. <br>