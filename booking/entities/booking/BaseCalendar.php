<?php


namespace booking\entities\booking;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BaseCalendar
 * @package booking\entities\booking
 * @property integer $id
 * @property BaseBooking[] $bookings
 * @property BaseSelling[] $selling
 */
abstract class BaseCalendar extends ActiveRecord
{

    public function isFor($id)
    {
        return $this->id == $id;
    }

    abstract public function isEmpty(): bool;

    abstract public function getBookings(): ActiveQuery;

    abstract public function getAllBookings(): ActiveQuery;

    abstract public function getSelling(): ActiveQuery;

    abstract public function isBooking();

    abstract public function isCancelProvider(): bool;

    abstract protected function _count(): int;

    abstract public function free(): int;

    abstract public function getDate_at(): int;

    abstract public function setDate_at(int $date_at): void;

    abstract public function cloneDate(int $date_at): self;

}