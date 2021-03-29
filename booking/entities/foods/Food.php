<?php


namespace booking\entities\foods;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\funs\WorkMode;
use booking\entities\Meta;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Food
 * @package booking\entities\foods
 *
 ********************************** Основные поля
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $visible
 * @property integer $main_photo_id
 * @property string $name
 * @property string $description
 *
 ********************************* Внешние связи
 * @property Meta $meta
 * @property InfoAddress[] $address
 * @property WorkMode[] $workMode
 * @property Kitchen[] $kitchens Тип кухни
 * @property KitchenAssign[] $kitchenAssign
 * @property Category[] $categories ... Доставка (без столиков) Ресторан, Кафе, Уличное кафе, Бар, Пивной паб
 * @property CategoryAssign[] $categoryAssign
 * @property Contact[] $contacts
 * @property ContactAssign[] $contactAssign
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property ReviewFood[] $reviews
 *
 *********************************** Скрытые поля
 * @property string $meta_json
 * @property string $work_mode_json
 */
class Food extends ActiveRecord
{

    public function create($name, $description): self
    {
        $food = new static();
        $food->name = $name;
        $food->description = $description;
        $food->created_at = time();
        $food->meta = new Meta();
        $food->visible = false;
        return $food;
    }

    public function visible(): void
    {
        $this->visible = true;
    }

    public function isVisible():bool
    {
        return $this->visible;
    }

    public static function tableName()
    {
        return '{{%foods}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'reviews',
                    'contactAssign',
                    'kitchenAssign',
                    'categoryAssign',
                ],
            ],
            MetaBehavior::class,
            TimestampBehavior::class,
        ];
    }

    public function afterFind()
    {
        $workMode = [];
        $_w = json_decode($this->getAttribute('work_mode_json'), true);
        for ($i = 0; $i < 7; $i++) {
            if (isset($_w[$i])) {
                $workMode[$i] = new WorkMode($_w[$i]['day_begin'], $_w[$i]['day_end'], $_w[$i]['break_begin'], $_w[$i]['break_end']);
            } else {
                $workMode[$i] = new WorkMode();
            }
        }
        $this->workMode = $workMode;
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('work_mode_json', json_encode($this->workMode));
        return parent::beforeSave($insert);
    }
}