<?php


namespace booking\repositories\booking\tours;


use booking\entities\admin\Legal;
use booking\entities\booking\tours\stack\AssignStack;
use booking\entities\booking\tours\stack\Stack;

class StackTourRepository
{
    public function get($id): Stack
    {
        if (!$result = Stack::findOne($id)) {
            throw new \DomainException('Дополнение на найдено');
        }
        return $result;
    }

    public function getByTour($tour_id):? Stack
    {
        $assign = AssignStack::find()->andWhere(['tour_id' => $tour_id])->one();
        if (!$assign) return null;
        return Stack::findOne($assign->stack_id);
    }

    public function getByLegal($legal_id)
    {
        return Stack::find()->andWhere(['legal_id' => $legal_id])->all();
    }

    public function getByUser($user_id)
    {
        return Stack::find()->andWhere([
            'IN',
            'legal_id',
            Legal::find()->select('id')->andWhere(['user_id' => $user_id])
        ])->all();
    }

    public function save(Stack $stack): void
    {
        if (!$stack->save()) {
            throw new \DomainException('Дополнение не сохранено');
        }
    }

    public function remove(Stack $stack)
    {
        if (!$stack->delete()) {
            throw new \DomainException('Ошибка удаления дополнения');
        }
    }


}