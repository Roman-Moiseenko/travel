<?php


namespace booking\forms\admin;


use booking\entities\admin\Notice;
use booking\forms\CompositeForm;

/**
 * Class NoticeForm
 * @package booking\forms\admin
 * @property NoticeItemForm $review
 * @property NoticeItemForm $bookingNew
 * @property NoticeItemForm $bookingPay
 * @property NoticeItemForm $bookingCancel
 * @property NoticeItemForm $bookingCancelPay
 * @property NoticeItemForm $messageNew
 */
class NoticeForm extends CompositeForm
{

    public function __construct(Notice $notice, $config = [])
    {
        $this->review = new NoticeItemForm($notice->review, 'review');
        $this->bookingNew = new NoticeItemForm($notice->bookingNew, 'bookingNew');
        $this->bookingPay = new NoticeItemForm($notice->bookingPay, 'bookingPay');
        $this->bookingCancel = new NoticeItemForm($notice->bookingCancel, 'bookingCancel');
        $this->bookingCancelPay = new NoticeItemForm($notice->bookingCancelPay, 'bookingCancelPay');
        $this->messageNew = new NoticeItemForm($notice->messageNew, 'messageNew');
        parent::__construct($config);
    }


    protected function internalForms(): array
    {
        return [
            'review',
            'bookingNew',
            'bookingPay',
            'bookingCancel',
            'bookingCancelPay',
            'messageNew'
        ];
    }
}