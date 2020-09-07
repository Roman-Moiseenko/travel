<?php


namespace admin\widgest;

use booking\repositories\booking\BookingRepository;
use yii\base\Widget;

class BookingTopBarWidget extends Widget
{
    public $days = 1;

    /**
     * @var BookingRepository
     */
    private $bookings;

    public function __construct(BookingRepository $bookings, $config = [])
    {
        parent::__construct($config);
        $this->bookings = $bookings;
    }

    public function run()
    {
        $bookings = $this->bookings->getByAdminNextDay(\Yii::$app->user->id, $this->days);
        $count = 0;
        foreach ($bookings as $booking){
            $count += (int)$booking['count'];
        }

        return $this->render('booking_top_bar', [
            'bookings' => $bookings,
            'count' => $count,
        ]);
    }
}