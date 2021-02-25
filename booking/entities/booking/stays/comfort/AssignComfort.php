<?php


namespace booking\entities\booking\stays\comfort;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class assignComfort
 * @package booking\entities\booking\stays\comfort
 * @property integer $stay_id
 * @property integer $comfort_id
 * @property boolean $pay
 * @property integer $photo_id
 * @property Comfort $comfort
 */
class AssignComfort extends ActiveRecord
{

    public static function create($comfort_id, $pay = null, $photo_id = null): self
    {
        $assign = new static();
        $assign->comfort_id = $comfort_id;
        $assign->pay = $pay;
        $assign->photo_id = $photo_id;
        return $assign;
    }

    public function edit($pay = null, $photo_id = null): void
    {
        $this->photo_id = $photo_id;
        $this->pay = $pay;
    }

    public static function tableName()
    {
        return '{{%booking_stays_comfort_assign}}';
    }

    public function getComfort(): ActiveQuery
    {
        return $this->hasOne(Comfort::class, ['id' => 'comfort_id'])->orderBy(['category_id' => SORT_ASC, 'sort' => SORT_ASC]);
    }

    public function isFor($id)
    {
        return $this->comfort_id == $id;
    }
}