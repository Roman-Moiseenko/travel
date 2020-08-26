<?php


namespace booking\forms\admin;


use booking\entities\admin\user\Notice;
use booking\entities\admin\user\NoticeItem;
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
        $this->review = new NoticeItemForm($notice->review);
        $this->bookingNew = new NoticeItemForm($notice->bookingNew);
        $this->bookingPay = new NoticeItemForm($notice->bookingPay);
        $this->bookingCancel = new NoticeItemForm($notice->bookingCancel);
        $this->bookingCancelPay = new NoticeItemForm($notice->bookingCancelPay);
        $this->messageNew = new NoticeItemForm($notice->messageNew);
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