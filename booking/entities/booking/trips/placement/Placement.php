<?php


namespace booking\entities\booking\trips\placement;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\Meals;
use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\trips\placement\room\Room;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Placement
 * @package booking\entities\booking\trips\placement
 * @property integer $id
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $created_at
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property integer $main_photo_id
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 * @property Type $type
 * @property AssignComfort[] $assignComforts
 * @property Comfort[] $comforts
 * @property MealsAssignment[] $mealsAssignment
 * @property Meals[] $meals
 * @property Room[] $rooms
 *
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 *
 *
 */
class Placement extends ActiveRecord
{
    /** @var $address BookingAddress */
    public $address;

    public static function create($user_id, $type_id, $name, $name_en, $description, $description_en, BookingAddress $address): self
    {
        $placement = new static();
        $placement->user_id = $user_id;
        $placement->type_id = $type_id;
        $placement->name = $name;
        $placement->name_en = $name_en;
        $placement->description = $description;
        $placement->description_en = $description_en;
        $placement->address = $address;
        $placement->created_at = time();
        return $placement;
    }

    public function edit($type_id, $name, $name_en, $description, $description_en, BookingAddress $address): void
    {
        $this->type_id = $type_id;
        $this->name = $name;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;
        $this->address = $address;
    }

    public static function tableName()
    {
        return '{{%booking_trips_placement}}';
    }

    public function behaviors()
    {
        return [
            BookingAddressBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'assignComforts',
                    'mealsAssignment',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }
    //====== MealsAssignment         ============================================

    public function getMealAssignment(int $id)
    {
        $meals = $this->mealsAssignment;
        foreach ($meals as $meal) {
            if ($meal->isFor($id)) return $meal;
        }
        return null;
    }

    public function assignMeal($id, $cost)
    {
        $meals = $this->mealsAssignment;
        foreach ($meals as $meal) {
            if ($meal->isFor($id)) return;
        }
        $meal = MealsAssignment::create($id, $cost);
        $meals[] = $meal;
        $this->mealsAssignment = $meals;
    }

    public function revokeMeal($id)
    {
        $meals = $this->mealsAssignment;
        foreach ($meals as $i => $meal) {
            if ($meal->isFor($id)) {
                unset($meals[$i]);
                $this->mealsAssignment = $meals;
                return;
            }
        }
    }

    public function revokeMeals()
    {
        $this->mealsAssignment = [];
    }

    //====== AssignComfort         ============================================

    public function getAssignComfort(int $id)
    {
        $comforts = $this->assignComforts;
        foreach ($comforts as $comfort) {
            if ($comfort->isFor($id)) return $comfort;
        }
        return null;
    }

    public function addComfort($id)
    {
        $comforts = $this->assignComforts;
        foreach ($comforts as $comfort) {
            if ($comfort->isFor($id)) return;
        }
        $comfort = AssignComfort::create($id);
        $comforts[] = $comfort;
        $this->assignComforts = $comforts;
    }

    public function revokeComfort($id)
    {
        $comforts = $this->assignComforts;
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id)) {
                unset($comforts[$i]);
                $this->assignComforts = $comforts;
                return;
            }
        }
    }

    public function revokeComforts()
    {
        $this->assignComforts = [];
    }

    //====== Photo         ============================================

    public function addPhoto(BasePhoto $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
        $this->updatePhotos($photos);
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    protected function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['placement_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getAssignComforts(): ActiveQuery
    {
        return $this->hasMany(AssignComfort::class, ['placement_id' => 'id']);
    }

    public function getComforts(): ActiveQuery
    {
        return $this->hasMany(Comfort::class, ['id' => 'comfort_id'])->via('assignComforts');
    }

    public function getMealsAssignment(): ActiveQuery
    {
        return $this->hasMany(MealsAssignment::class, ['placement_id' => 'id']);
    }

    public function getMeals(): ActiveQuery
    {
        return $this->hasMany(Meals::class, ['id' => 'meal_id'])->via('mealsAssignment');
    }

    public function getRooms(): ActiveQuery
    {
        return $this->hasMany(Room::class, ['placement_id' => 'id'])->orderBy(['cost' => SORT_ASC]);
    }

    //**********************************
    public function getComfortsSortCategory(): array
    {
        $result = [];
        foreach ($this->assignComforts as $assignComfort) {
            $category = $assignComfort->comfort->category;
            $result[$category->id]['name'] = $category->name;
            $result[$category->id]['image'] = $category->image;
            $result[$category->id]['items'][] = [
                'name' => $assignComfort->comfort->name,
            ];
        }
        return $result;
    }


}