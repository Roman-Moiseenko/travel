<?php


namespace booking\entities\foods;


use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;

/**
 * Class Kitchen
 * @package booking\entities\foods
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Kitchen extends ActiveRecord
{
    public static function create(string $name): self
    {
        $kitchen = new static();
        $kitchen->name = $name;
        $kitchen->slug = SlugHelper::slug($name);
        return $kitchen;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%foods_kitchen}}';
    }
}