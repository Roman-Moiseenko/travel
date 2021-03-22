<?php


namespace booking\entities\booking\stays;


use booking\entities\booking\BaseSelling;
use yii\db\ActiveQuery;

/**
 * Class SellingTour
 * @package booking\entities\booking\tours
 * @property int $id
 * @property int $calendar_id
 * @property int $count
 * @property int $created_at
 * @property CostCalendar $calendar
 */
class SellingStay extends BaseSelling
{
    public static function tableName()
    {
        return '{{%selling_stay}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}