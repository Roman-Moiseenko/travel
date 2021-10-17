<?php


namespace frontend\widgets\info;


use booking\forms\realtor\BookingLandowner;
use yii\base\Widget;

class BookingLandownerWidget extends Widget
{
    public $landowner_id;

    public function run()
    {
        $form = new BookingLandowner();
        $form->landowner_id = $this->landowner_id;

        $action = '/realtor/landowners/booking';
        return $this->render('booking_landowner', [
            'action' => $action,
            'model' => $form,
        ]);
    }
}