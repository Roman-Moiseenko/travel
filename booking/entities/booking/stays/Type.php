<?php


namespace booking\entities\booking\stays;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class StaysType
 * @package booking\entities\booking
 * @property integer $id
 * @property string $name
 * @property bool $mono
 */
class Type extends ActiveRecord
{
    public static function create($name, $mono): self
    {
        $staystype = new static();
        $staystype->name = $name;
        $staystype->mono = $mono;
        return $staystype;
    }

    public function edit($name, $mono): void
    {
        $this->name = $name;
        $this->mono = $mono;
    }

    public function isMono(): bool
    {
        return $this->mono;
    }

    public static function tableName()
    {
        return 'booking_stays_type';
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasMany(Stays::class, ['type_id' => 'id']);
    }
}