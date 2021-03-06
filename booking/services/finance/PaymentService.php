<?php


namespace booking\services\finance;


use booking\entities\booking\BookingItemInterface;
use booking\entities\finance\Payment;
use booking\repositories\finance\PaymentRepository;

class PaymentService
{
    /**
     * @var PaymentRepository
     */
    private $payments;

    public function __construct(PaymentRepository $payments)
    {
        $this->payments = $payments;
    }

    public function create(BookingItemInterface $booking): Payment
    {
        $payment = Payment::create(
            $booking->getId(),
            $booking->getLegal()->id,
            get_class($booking),
            $booking->getPaymentToProvider()
        );
        $this->payments->save($payment);
        return $payment;
    }

    public function pay($id): void
    {
        $payment = $this->payments->get($id);
        $payment->pay();
        $this->payments->save($payment);
    }
}