<?php


namespace booking\entities\blog\map;


use booking\entities\booking\BookingAddress;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Maps
 * @package booking\entities\blog\map
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Point[] $points
 */
class Maps extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $map = new static();
        $map->name = $name;
        $map->slug = $slug;
        return $map;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function addPoint(Point $point): void
    {
        $points = $this->points;
        foreach ($points as $item) {
            if ($item->equal($point)) throw new \DomainException('Точка с такими параметрами уже имеется');
        }
        $points[] = $point;
        $this->points = $points;
    }

    public function updatePoint($point_id, $caption, $link, BookingAddress $geo, $photo): void
    {
        $points = $this->points;
        foreach ($points as $i => &$item) {
            if ($item->isFor($point_id)) {
                $item->edit(
                    $caption,
                    $link,
                    $geo,
                    $photo
                    );
                $this->points = $points;
                return;
            }
        }
        throw new \DomainException('Точка не найдена');

    }

    public function removePoint($id): void
    {
        $points = $this->points;
        foreach ($points as $i => $point) {
            if ($point->isFor($id)) {
                unset($points[$i]);
                $this->points = $points;
                return;
            }
        }
        throw new \DomainException('Точка не найдена');
    }

    public static function tableName()
    {
        return '{{%blog_maps}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'points',
                ]
            ]
        ];
    }

    public function getPoints(): ActiveQuery
    {
        return $this->hasMany(Point::class, ['map_id' => 'id']);
    }

    public function getPoint($point_id)
    {
        $points = $this->points;
        foreach ($points as $point) {
            if ($point->isFor($point_id)) return $point;
        }
        throw new \DomainException('Точка не найдена');
    }
}