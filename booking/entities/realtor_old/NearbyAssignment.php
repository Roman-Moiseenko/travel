<?php


namespace booking\entities\realtor_old;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @package booking\entities\realtor
 * @property integer $nearby_id
 * @property integer $plot_id
 * @property string $name
 * @property integer $distance
 * @property string $unit
 * @property Nearby $nearby
 */
class NearbyAssignment extends ActiveRecord
{
    public static function create($name, $distance, $unit): self
    {
        $nearby = new static();
        $nearby->name = $name;
        $nearby->distance = $distance;
        $nearby->unit = $unit;
        return $nearby;
    }

    public function isFor($id): bool
    {
        return $this->nearby_id == $id;
    }

    public static function tableName()
    {
        return '{{%realtor_plots_nearby_assign}}';
    }

    public function getNearby(): ActiveQuery
    {
        return $this->hasOne(Nearby::class, ['id' => '$nearby_id']);
    }

}