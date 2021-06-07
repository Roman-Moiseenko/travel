<?php


namespace booking\entities\vmuseum;


use yii\db\ActiveRecord;
//Экскурсии в которые есть музей (1 )

/**
 * Class AssignTour
 * @package booking\entities\vmuseum
 * @property integer $vmuseum_id
 * @property integer $tour_id
 */
class AssignTour extends ActiveRecord
{
    public static function create($tour_id): self
    {
        $assign = new static();
        $assign->tour_id = $tour_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->tour_id == $id;
    }

    public static function tableName()
    {
        return '{{%vmuseum_assign_tour}}';
    }
}