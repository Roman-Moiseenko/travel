<?php


namespace booking\services\finance;


use booking\entities\booking\BaseBooking;
use booking\entities\finance\Movement;
use booking\entities\finance\Payment;
use booking\entities\PaymentInterface;
use booking\repositories\finance\MovementRepository;
use booking\repositories\finance\PaymentRepository;

class MovementService
{
    /**
     * @var MovementRepository
     */
    private $payments;

    public function __construct(MovementRepository $payments)
    {
        $this->payments = $payments;
    }

    public function create(PaymentInterface $booking): Movement
    {
        $payment = Movement::create($booking);
        $this->payments->save($payment);
        return $payment;
    }

    public function paid(string $payment_id): void
    {
        $payment = $this->payments->getByPaymentId($payment_id);
        $payment->paid();
        $this->payments->save($payment);
    }
}