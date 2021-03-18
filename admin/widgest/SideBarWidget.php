<?php


namespace admin\widgest;


use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\ReviewRepository;
use yii\base\Widget;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class SideBarWidget extends Widget
{
    private $reviews;
    /**
     * @var BookingRepository
     */
    private $bookings;


    public function __construct(ReviewRepository $reviews, BookingRepository $bookings, $config = [])
    {
        parent::__construct($config);
        $this->reviews = $reviews;
        $this->bookings = $bookings;
    }

    public function run()
    {
        $events = [];
        $reviews = $this->reviews->getByAdmin(\Yii::$app->user->id, 1);
        foreach ($reviews as $review) {
            $events[] = [
                'date' => $review->getDate(),
                'event' => 'Отзыв ' . StringHelper::truncateWords(strip_tags($review->getName()), 3),
                'link' => $review->getLinks()['admin'],
                ];
        }
        $bookings = $this->bookings->getByAdminLastCreated(\Yii::$app->user->id, 1);
        foreach ($bookings as $booking) {
            $events[] = [
                'date' => $booking->getCreated(),
                'event' => 'Бронирование ' . StringHelper::truncateWords(strip_tags($booking->getName()), 3),
                'link' => $booking->getLinks()->admin,
            ];
        }

        usort($events, function ($a, $b) {
            if ($a['date'] > $b['date']) {
                return -1;
            } else {
                return 1;
            }
        });

        return $this->render('side_bar', [
            'events' => $events, //array_slice($events, 0, (count($events) > 14) ? 14 : count($events))
        ]);
    }
}