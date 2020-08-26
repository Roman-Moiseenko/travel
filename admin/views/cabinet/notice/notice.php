<?php

/* @var $user User */

use booking\entities\admin\user\Notice;
use booking\entities\admin\user\User;
use booking\forms\admin\NoticeForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $notice Notice */
/* @var $model NoticeForm */

$this->title = 'Уведомления';
$this->params['breadcrumbs'][] = $this->title;
// TODO       ДОДЕЛАТЬ + AJAX
?>

<div>

    <div class="card card-secondary">
        <div class="card-body">
            <table width="80%">
                <tbody>
                <tr>
                    <th>Отзывы</th>
                    <td>
                        <div class="checkbox">
                            <label for="review-email">
                                <input id="review-email" type="checkbox" class="notice-ajax" value="1" data-item="review" data-field="email" <?= $notice->review->email ? 'checked' : ''?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="review-phone">
                                <input id="review-phone" type="checkbox" class="notice-ajax" value="1" data-item="review" data-field="phone" <?= $notice->review->phone ? 'checked' : ''?>>
                                Уведомление по СМС
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Новое бронирование</th>
                    <td>
                        <div class="checkbox">
                            <label for="bookingNew-email">
                                <input id="bookingNew-email" type="checkbox" class="notice-ajax" value="1" data-item="bookingNew" data-field="email" <?= $notice->bookingNew->email ? 'checked' : ''?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="bookingNew-phone">
                                <input id="bookingNew-phone" type="checkbox" class="notice-ajax" value="1" data-item="bookingNew" data-field="phone" <?= $notice->bookingNew->phone ? 'checked' : ''?>>
                                Уведомление по СМС
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Оплата бронирования</th>
                    <td>
                        <div class="checkbox">
                            <label for="bookingPay-email">
                                <input id="bookingPay-email" type="checkbox" class="notice-ajax" value="1" data-item="bookingPay" data-field="email" <?= $notice->bookingPay->email ? 'checked' : ''?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="bookingPay-phone">
                                <input id="bookingPay-phone" type="checkbox" class="notice-ajax" value="1" data-item="bookingPay" data-field="phone" <?= $notice->bookingPay->phone ? 'checked' : ''?>>
                                Уведомление по СМС
                            </label>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
