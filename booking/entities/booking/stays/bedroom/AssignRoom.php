<?php


namespace booking\entities\booking\stays\bedroom;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AssignRoom
 * @package booking\entities\booking\stays\bedroom
 * @property integer $id
 * @property integer $stay_id
 * @property integer $sort
 * @property bool $living ... true - гостиная, false - спальня
 * @property AssignBed[] $assignBeds
 */
class AssignRoom extends ActiveRecord
{
    public static function create($stay_id, $sort, $living = false): self
    {
        $assign = new static();
        $assign->stay_id = $stay_id;
        $assign->sort = $sort;
        $assign->living = $living;
        return $assign;
    }

    public function addBed(AssignBed $assignBed): void
    {
        $beds = $this->assignBeds;
        foreach ($beds as $bed) {
            if ($bed->isFor($assignBed->bed_id)) {
                throw new \DomainException('Уже добавлена');
            }
        }
        $beds[] = $assignBed;
        $this->assignBeds = $beds;
    }

    public function getCount(int $id):? int
    {
        $beds = $this->assignBeds;
        foreach ($beds as $bed) {
            if ($bed->isFor($id)) {
                return $bed->count;
            }
        }
        return null;
    }

    public function removeBed($bed_id): void
    {
        $beds = $this->assignBeds;
        foreach ($beds as $i => $bed) {
            if ($bed->isFor($bed_id)) {
                unset($beds[$i]);
                $this->assignBeds = $beds;
                return;
            }
        }

        throw new \DomainException('Кровать не найдена');
    }

    public function clearBeds()
    {
        $this->assignBeds = [];
    }

    public static function tableName()
    {
        return '{{%booking_stays_rooms_assign}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'assignBeds',
                ],
            ],
        ];
    }

    public function getAssignBeds(): ActiveQuery
    {
        return $this->hasMany(AssignBed::class, ['assignRoom_id' => 'id']);
    }




}