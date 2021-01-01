<?php


namespace admin\widgest\report;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use yii\base\Widget;

class StaticWidget extends Widget
{

    public $object;

    public function run()
    {
        $views = $this->object->views;
        $next_amount = 0 ;
        $last_tickets = 0;
        $last_amount = 0;
//TODO Стат данные по финансам объекта !!!!!!!!!!!
        if (get_class($this->object) == Tour::class) {
            //$next_amount = BookingTour::find()->andWhere(['']);
            //$last_tickets = 0;
            //$last_amount = 0;

        }


        return $this->render('static', [
            'views' => $views,
            'next_amount' => $next_amount,
            'last_tickets' => $last_tickets,
            'last_amount' => $last_amount,
        ]);
    }
}