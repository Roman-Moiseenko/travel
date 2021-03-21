<?php


namespace booking\services\booking\stays;



use booking\entities\booking\stays\BookingStay;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\repositories\booking\stays\BookingStayRepository;

use booking\repositories\booking\stays\CostCalendarRepository;
use booking\services\booking\BookingService;

use booking\services\ContactService;
use booking\services\finance\RefundService;



class BookingStayService extends BookingService
{

    /**
     * @var BookingStayRepository
     */
    private $bookings;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;
    /**
     * @var ContactService
     */
    private $contact;
    /**
     * @var RefundService
     */
    private $refund;

    public function __construct(
        BookingStayRepository $bookings,
        CostCalendarRepository $calendar,
        ContactService $contact,
        RefundService $refund
    )
    {
        $this->bookings = $bookings;
        $this->calendar = $calendar;
        $this->contact = $contact;
        $this->refund = $refund;
    }

    public function create($params): BookingStay
    {
        //$calendar = $this->calendar->get($calendar_id);
        $stay = $this->stays->get($params['stay_id']);
        //Выполнить проверку на места
        if (!$stay->checkBySearchParams($params)) {  //кол-во свободных меньше покупаемого
            throw new \DomainException(Lang::t('Упс! Места закончились'));
        }

        $booking = BookingStay::create($params);
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
        return $booking;
    }

    public function remove($id)
    {
        $booking = $this->bookings->get($id);
        $this->bookings->remove($booking->id);
    }

    public function cancel($id)
    {
        $booking = $this->bookings->get($id);
        $booking->cancel();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function cancelPay($id)
    {
        $booking = $this->bookings->get($id);
        $tour = $booking->calendar->tour;
        if ($tour->cancellation == null)
            throw new \DomainException(Lang::t('Отмена не предусмотрена'));
        if ($tour->cancellation * 3600 * 24 > $booking->calendar->tour_at - time())
            throw new \DomainException(Lang::t('Срок отмены истек'));
        if ($booking->calendar->tour_at < time())
            throw new \DomainException(Lang::t('Тур завершен'));
        $booking->cancelPay();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function confirmation($id)
    {
        $booking = $this->bookings->get($id);
        $booking->confirmation();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function pay($id)
    {
        $booking = $this->bookings->get($id);
        $booking->pay();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function noticeConfirmation($id, $template = 'pay')
    {
        $booking = $this->bookings->get($id);
        if (!empty($booking->getConfirmationCode())) {
            $this->contact->sendNoticeConfirmation($booking, $template);
            return;
        }
        $code = uniqid();
        $booking->setConfirmation($code);
        $this->bookings->save($booking);
        $this->contact->sendNoticeConfirmation($booking, $template);
    }

    public function checkConfirmation($id, ConfirmationForm $form): bool
    {
        $booking = $this->bookings->get($id);
        return $booking->getConfirmationCode() == $form->confirmation;
    }

    private function cancelNotPay($day = 1)
    {
        /** @var BookingStay[] $bookings */
        $bookings = $this->bookings->getNotPay($day);
        foreach ($bookings as $booking) {
            $booking->cancel();
            $this->bookings->save($booking);
        }
    }

    public function cancelProvider($calendar_id)
    {
        $bookings = $this->bookings->getByCalendar($calendar_id);
        foreach ($bookings as $booking) {
            if ($booking->isPay()) { // если был оплачен, отмена с возвратом
                $this->refund->create($booking); //сформировать на возврат оплаты
                $booking->cancelPay(); // отменить оплату
            } else {
                $booking->cancel(); // если не оплачен, просто отмена
            }
            $this->bookings->save($booking);
            $this->contact->sendNoticeBooking($booking); // отправить письмо

        }
    }
}