<?php


namespace booking\entities\booking\trips\placement\room;


use booking\entities\booking\BasePhoto;
use booking\entities\booking\Meals;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\Lang;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Rooms
 * @package booking\entities\booking\trips\placement
 * @property integer $id
 * @property integer $placement_id
 * @property string $name
 * @property string $name_en
 * @property integer $main_photo_id
 * @property integer $quantity
 * @property integer $meals_id ... если null - то на выбор из списка или нет вовсе, если = id, то включено
 *
 * @property integer $cost // стоимость за номер  если $shared == false и за 1 человека если $shared == true
 * @property integer $capacity // Максимальная вместимость
 * @property bool $shared //общий номер, если true
 *
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 * @property AssignComfortRoom[] $assignComforts
 * @property ComfortRoom[] $comforts
 * @property Meals $meals

 *
 */
class Room extends ActiveRecord
{
    public static function create($placement_id, $name, $name_en, $meals_id, $quantity, $cost, $capacity, $shared): self
    {
        $room = new static();
        $room->placement_id = $placement_id;
        $room->name = $name;
        $room->name_en = $name_en;
        $room->meals_id = $meals_id;
        $room->quantity = $quantity;
        $room->cost = $cost;
        $room->capacity = $capacity;
        $room->shared = $shared;
        return $room;
    }

    public function edit($name, $name_en, $meals_id, $quantity, $cost, $capacity, $shared): void
    {
        $this->name = $name;
        $this->name_en = $name_en;
        $this->meals_id = $meals_id;
        $this->quantity = $quantity;
        $this->cost = $cost;
        $this->capacity = $capacity;
        $this->shared = $shared;
    }


    public static function tableName()
    {
        return '{{%booking_trips_placement_room}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'assignComforts',
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
        $comfort = AssignComfortRoom::create($id);
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

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['room_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getAssignComforts(): ActiveQuery
    {
        return $this->hasMany(AssignComfortRoom::class, ['room_id' => 'id']);
    }

    public function getComforts(): ActiveQuery
    {
        return $this->hasMany(ComfortRoom::class, ['id' => 'comfort_id'])->via('assignComforts');
    }

    //**********************************
    public function getComfortsSortCategory(): array
    {
        $result = [];
        foreach ($this->assignComforts as $assignComfort) {
            $category = $assignComfort->comfort->category;
            if ($assignComfort->comfort->featured) {
                $result[0]['name'] = 'Популярные удобства';
                $result[0]['image'] = '';
                $result[0]['items'][] = [
                    'name' => $assignComfort->comfort->name,
                ];
            } else {
                $result[$category->id]['name'] = $category->name;
                $result[$category->id]['image'] = $category->image;
                $result[$category->id]['items'][] = [
                    'name' => $assignComfort->comfort->name,
                ];
            }
        }
        return $result;
    }

    private function getMeals(): ActiveQuery
    {
        return $this->hasOne(Meals::class, ['id' => 'meals_id']);
    }

    public function Meals(): string
    {
        if ($this->meals_id == null) return 'Не назначено';
        return $this->meals->mark . '(' . Lang::t($this->meals->name) . ')';
    }
}