<?php


namespace booking\entities\land;


use yii\db\ActiveRecord;

/**
 * Class Land
 * @package booking\entities\land
 * @property integer $id
 * @property string $name
 * @property integer $min_price
 * @property string $points_json
 * @property integer $count
 *
 */

class Land extends ActiveRecord
{
    /** @var $points Point[]  */
    public $points = [];

    public static function create($name, $min_price, $count): self
    {
        $land = new static();
        $land->name = $name;
        $land->min_price = $min_price;
        $land->count = $count;
        return $land;
    }


    public function edit($name, $min_price, $count): void
    {
        $this->name = $name;
        $this->min_price = $min_price;
        $this->count = $count;
    }

    public function setPoints(array $points): void
    {
        $this->points = $points;
    }

    public static function tableName()
    {
        return '{{%land_anonymous}}';
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub

        $points = json_decode($this->getAttribute('points_json'));
        foreach ($points as $point) {
            //$this->points[] = Point::create($point['latitude'], $point['longitude']);
            $this->points[] = Point::create($point->latitude, $point->longitude);
        }
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('points_json', json_encode($this->points));
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function addPoint(Point $point): void
    {
        $this->points[] = $point;
    }

    public function clearPoints(): void
    {
        $this->points = [];
    }

}