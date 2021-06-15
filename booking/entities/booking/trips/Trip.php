<?php


namespace booking\entities\booking\trips;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\booking\LinkBooking;
use yii\db\ActiveQuery;

class Trip extends BaseObjectOfBooking
{


    public function getActualCalendar(): ActiveQuery
    {
        // TODO: Implement getActualCalendar() method.
    }

    public function getMainPhoto(): ActiveQuery
    {
        // TODO: Implement getMainPhoto() method.
    }

    public function getReviews(): ActiveQuery
    {
        // TODO: Implement getReviews() method.
    }

    public function getPhotos(): ActiveQuery
    {
        // TODO: Implement getPhotos() method.
    }
}