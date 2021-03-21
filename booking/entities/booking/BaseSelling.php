<?php


namespace booking\entities\booking;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BaseSelling
 * @package booking\entities\booking
 * @property int $id
 * @property int $calendar_id
 * @property int $count
 * @property int $created_at
 * @property BaseCalendar $calendar
 */

abstract class BaseSelling extends ActiveRecord
{

    public static function create($calendar_id, $count): self
    {
        $selling = new static();
        $selling->calendar_id = $calendar_id;
        $selling->count = $count;
        $selling->created_at = time();
        return $selling;
    }

    abstract public function getCalendar(): ActiveQuery;
}