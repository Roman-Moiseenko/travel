<?php


namespace booking\services\finance;


use booking\entities\booking\BaseBooking;
use booking\entities\finance\Payment;
use booking\entities\PaymentInterface;
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

    public function create(PaymentInterface $booking): Payment
    {
        $payment = Payment::create(
            $booking->getId(),
            $booking->getLegal()->id,
            get_class($booking),
            $booking->getPayment()->getProvider()
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