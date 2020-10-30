<?php


namespace booking\entities\admin;

use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Notice
 * @package booking\entities\admin\user
 * @property string $notice
 */
class Notice extends ActiveRecord
{
    /** @var NoticeItem */
    public $review;
    /** @var NoticeItem */
    public $bookingNew;
    /** @var NoticeItem */
    public $bookingPay;
    /** @var NoticeItem */
    public $bookingCancel;
    /** @var NoticeItem */
    public $bookingCancelPay;
    /** @var NoticeItem */
    public $messageNew;
    /** @var NoticeItem */
    public $bookingConfirmation;


    public static function create(): self
    {
        $notice = new static();
        $notice->review = new NoticeItem();
        $notice->bookingNew = new NoticeItem();
        $notice->bookingPay = new NoticeItem();
        $notice->bookingCancel = new NoticeItem();
        $notice->bookingCancelPay = new NoticeItem();
        $notice->bookingConfirmation = new NoticeItem();
        $notice->messageNew = new NoticeItem();
        return $notice;
    }

    public function edit(NoticeItem $review, NoticeItem $bookingNew,
                         NoticeItem $bookingPay, NoticeItem $bookingCancel,
                         NoticeItem $bookingCancelPay, NoticeItem $messageNew,
                         NoticeItem $bookingConfirmation
)
    {
        $this->review = $review;
        $this->bookingNew = $bookingNew;
        $this->bookingPay = $bookingPay;
        $this->bookingCancel = $bookingCancel;
        $this->bookingCancelPay = $bookingCancelPay;
        $this->bookingConfirmation = $bookingConfirmation;
        $this->messageNew = $messageNew;
    }

    public function afterFind(): void
    {
        $notice = Json::decode($this->getAttribute('notice'), true);
        if (isset($notice['review'])) {
            $this->review = new NoticeItem($notice['review']['email'], $notice['review']['phone']);
        } else {
            $this->review = new NoticeItem();
        }
        if (isset($notice['bookingNew'])) {
            $this->bookingNew = new NoticeItem($notice['bookingNew']['email'], $notice['bookingNew']['phone']);
        } else {
            $this->bookingNew = new NoticeItem();
        }

        //
        if (isset($notice['bookingPay'])) {
            $this->bookingPay = new NoticeItem($notice['bookingPay']['email'], $notice['bookingPay']['phone']);
        } else {
            $this->bookingPay = new NoticeItem();
        }
        if (isset($notice['bookingCancel'])) {
            $this->bookingCancel = new NoticeItem($notice['bookingCancel']['email'], $notice['bookingCancel']['phone']);
        } else {
            $this->bookingCancel = new NoticeItem();
        }
        if (isset($notice['bookingCancelPay'])) {
            $this->bookingCancelPay = new NoticeItem($notice['bookingCancelPay']['email'], $notice['bookingCancelPay']['phone']);
        } else {
            $this->bookingCancelPay = new NoticeItem();
        }
        if (isset($notice['bookingConfirmation'])) {
            $this->bookingConfirmation = new NoticeItem($notice['bookingConfirmation']['email'], $notice['bookingConfirmation']['phone']);
        } else {
            $this->bookingConfirmation = new NoticeItem();
        }

        if (isset($notice['messageNew'])) {
            $this->messageNew = new NoticeItem($notice['messageNew']['email'], $notice['messageNew']['phone']);
        } else {
            $this->messageNew = new NoticeItem();
        }
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('notice', Json::encode([
            'review' => $this->review,
            'bookingNew' => $this->bookingNew,
            'bookingPay' => $this->bookingPay,
            'bookingCancel' => $this->bookingCancel,
            'bookingCancelPay' => $this->bookingCancelPay,
            'bookingConfirmation' => $this->bookingConfirmation,
            'messageNew' => $this->messageNew
        ]));

        return parent::beforeSave($insert);
    }

    public static function tableName()
    {
        return '{{%admin_user_notice}}';
    }
}