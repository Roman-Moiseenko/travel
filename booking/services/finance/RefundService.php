<?php


namespace booking\services\finance;


use booking\entities\booking\BookingItemInterface;
use booking\entities\finance\Refund;
use booking\repositories\finance\RefundRepository;

class RefundService
{
    /**
     * @var RefundRepository
     */
    private $refunds;

    public function __construct(RefundRepository $refunds)
    {
        $this->refunds = $refunds;
    }

    public function create(BookingItemInterface $booking): Refund
    {
        $refund = Refund::create(
            $booking->getId(),
            get_class($booking),
            $booking->getAmountPay() * (1 - (\Yii::$app->params['merchant'] ?? 4) / 100)
        );
        $this->refunds->save($refund);
        return $refund;
    }

    public function refund($id): void
    {
        $refund = $this->refunds->get($id);
        $refund->refund();
        $this->refunds->save($refund);
    }
}