<?php


namespace booking\entities\booking\cars;


use booking\helpers\SlugHelper;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ToursType
 * @package booking\entities\booking\cars
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $sort
 * @property Characteristic[] $characteristics
 */
// @property bool $driver  - true - прокат возможен с водителем

class Type extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $type = new static();
        $type->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $type->slug = $slug;
        return $type;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $this->slug = $slug;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function addCharacteristic(Characteristic $characteristic)
    {
        $characteristics = $this->characteristics;
        $characteristics[] = $characteristic;
        $this->characteristics = $characteristics;
    }

    public function updateCharacteristic($id, $name, $type_variable, $required, $default, array $variants, $sort)
    {
        $characteristics = $this->characteristics;
        foreach ($characteristics as &$characteristic) {
            if ($characteristic->isFor($id)) {
                $characteristic->edit(
                    $name,
                    $type_variable,
                    $required,
                    $default,
                    $variants,
                    $sort
                );
                $this->characteristics = $characteristics;
                return;
            }
        }
        throw new \DomainException('Характеристика не найдена ID=' . $id);
    }

    public function removeCharacteristic(int $id)
    {
        $characteristics = $this->characteristics;
        foreach ($characteristics as $i => $characteristic) {
            if ($characteristic->isFor($id)) {
                unset($characteristics[$i]);
                $this->characteristics = $characteristics;
                return;
            }
        }
        throw new \DomainException('Характеристика не найдена ID=' . $id);
    }
    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'characteristics',
                ],
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%booking_cars_type}}';
    }

    public function getCharacteristics(): ActiveQuery
    {
        return $this->hasMany(Characteristic::class, ['type_car_id' => 'id']);
    }



}