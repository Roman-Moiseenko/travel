<?php


namespace booking\entities\booking\tours\stack;


use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class StackTour
 * @package booking\entities\booking\tours
 * @property int $id
 * @property int $legal_id
 * @property int $count
 * @property string $name
 * @property int $created_at
 * @property AssignStack[] $assignStacks
 * @property Legal $legal
 * @property Tour[] $tours
 */

class Stack extends ActiveRecord
{

    public static function create($legal_id, $count, $name): self
    {
        $stack = new static();
        $stack->legal_id = $legal_id;
        $stack->count = $count;
        $stack->name = $name;
        $stack->created_at = time();
        return $stack;
    }

    public function edit($legal_id, $count, $name): void
    {
        $this->legal_id = $legal_id;
        $this->count = $count;
        $this->name = $name;
    }

    public function addAssign($tour_id)
    {
        $assignStacks = $this->assignStacks;
        foreach ($assignStacks as $assignStack) {
            if ($assignStack->isFor($tour_id)){
                throw new \DomainException('Экскурсия уже в стеке');
            }
        }
        $assignStacks[] = AssignStack::create($tour_id);
        $this->assignStacks = $assignStacks;
    }

    public function removeAssign($tour_id)
    {
        $assignStacks = $this->assignStacks;
        foreach ($assignStacks as $i => $assignStack) {
            if ($assignStack->isFor($tour_id)){
                unset($assignStacks[$i]);
                $this->assignStacks = $assignStacks;
                return;
            }
        }
        throw new \DomainException('Экскурсии нет в стеке');
    }

    public function clearAssign()
    {
        $this->assignStacks = [];
    }

    public function isFor($id): bool
    {
        $assignStacks = $this->assignStacks;
        foreach ($assignStacks as $assignStack) {
            if ($assignStack->isFor($id)) return true;
        }
        return false;
    }



    public static function tableName()
    {
        return '{{%booking_tours_stack}}';
    }

    public function behaviors()
    {
        return [
            //TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'assignStacks',
                ],
            ],
        ];
    }

    public function getAssignStacks():ActiveQuery
    {
        return $this->hasMany(AssignStack::class, ['stack_id' => 'id']);
    }

    public function getTours(): ActiveQuery
    {
        return $this->hasMany(Tour::class, ['id' => 'tour_id'])->via('assignStacks');
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }

    public function _empty(): bool
    {

    }
}