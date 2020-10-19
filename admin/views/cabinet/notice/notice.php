<?php

/* @var $user \booking\entities\admin\User */

use booking\entities\admin\Notice;
use booking\entities\admin\User;
use booking\forms\admin\NoticeForm;
use yii\helpers\Url;

/* @var $notice Notice */
/* @var $model NoticeForm */

$this->title = 'Уведомления';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <div class="card card-secondary adaptive-width-80">
        <div class="card-body label-not-bold">
            <table width="80%" class ='table table-adaptive table-striped table-bordered'>
                <tbody>
                <tr>
                    <th>Отзывы</th>
                    <td>
                        <div class="checkbox">
                            <label for="review-email">
                                <input id="review-email" type="checkbox" class="notice-ajax" value="1"
                                       data-item="review"
                                       data-field="email" <?= $notice->review->email ? 'checked' : '' ?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="review-phone">
                                <input id="review-phone" type="checkbox" class="notice-ajax" value="1"
                                       data-item="review"
                                       data-field="phone" <?= $notice->review->phone ? 'checked' : '' ?> disabled>
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
                                <input id="bookingNew-email" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingNew"
                                       data-field="email" <?= $notice->bookingNew->email ? 'checked' : '' ?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="bookingNew-phone">
                                <input id="bookingNew-phone" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingNew"
                                       data-field="phone" <?= $notice->bookingNew->phone ? 'checked' : '' ?> disabled>
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
                                <input id="bookingPay-email" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingPay"
                                       data-field="email" <?= $notice->bookingPay->email ? 'checked' : '' ?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="bookingPay-phone">
                                <input id="bookingPay-phone" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingPay"
                                       data-field="phone" <?= $notice->bookingPay->phone ? 'checked' : '' ?>>
                                Уведомление по СМС
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Отмена не оплаченного бронирования</th>
                    <td>
                        <div class="checkbox">
                            <label for="bookingCancel-email">
                                <input id="bookingCancel-email" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingCancel"
                                       data-field="email" <?= $notice->bookingCancel->email ? 'checked' : '' ?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="bookingCancel-phone">
                                <input id="bookingCancel-phone" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingCancel"
                                       data-field="phone" <?= $notice->bookingCancel->phone ? 'checked' : '' ?> disabled>
                                Уведомление по СМС
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Отмена оплаченного бронирования</th>
                    <td>
                        <div class="checkbox">
                            <label for="bookingCancelPay-email">
                                <input id="bookingCancelPay-email" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingCancelPay"
                                       data-field="email" <?= $notice->bookingCancelPay->email ? 'checked' : '' ?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="bookingCancelPay-phone">
                                <input id="bookingCancelPay-phone" type="checkbox" class="notice-ajax" value="1"
                                       data-item="bookingCancelPay"
                                       data-field="phone" <?= $notice->bookingCancelPay->phone ? 'checked' : '' ?>>
                                Уведомление по СМС
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Новое сообщение</th>
                    <td>
                        <div class="checkbox">
                            <label for="messageNew-email">
                                <input id="messageNew-email" type="checkbox" class="notice-ajax" value="1"
                                       data-item="messageNew"
                                       data-field="email" <?= $notice->messageNew->email ? 'checked' : '' ?>>
                                Уведомление по email
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label for="messageNew-phone">
                                <input id="messageNew-phone" type="checkbox" class="notice-ajax" value="1"
                                       data-item="messageNew"
                                       data-field="phone" <?= $notice->messageNew->phone ? 'checked' : '' ?> disabled>
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
