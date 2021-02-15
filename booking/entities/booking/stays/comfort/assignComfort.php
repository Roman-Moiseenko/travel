<?php


namespace booking\entities\booking\stays\comfort;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class assignComfort
 * @package booking\entities\booking\stays\comfort
 * @property integer $stays_id
 * @property integer $comfort_id
 * @property boolean $pay
 * @property integer $photo
 * @property Comfort $comfort
 */
class assignComfort extends ActiveRecord
{

    public static function create($comfort_id, $pay = null, $photo = null): self
    {
        $assign = new static();
        $assign->comfort_id = $comfort_id;
        $assign->pay = $pay;
        $assign->photo = $photo;
        return $assign;
    }

    public function edit($pay = null, $photo = null): void
    {
        $this->photo = $photo;
        $this->pay = $pay;
    }

    public static function tableName()
    {
        return '{{%booking_stays_comfort_assign}}';
    }

    public function getComfort(): ActiveQuery
    {
        return $this->hasMany(Comfort::class, ['id' => 'comfort_id'])->orderBy(['category_id', 'sort']);
    }
}