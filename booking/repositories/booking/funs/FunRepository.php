<?php


namespace booking\repositories\booking\funs;


use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\Type;
use booking\forms\booking\funs\SearchFunForm;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class FunRepository
{
    public function get($id)
    {
        $fun = Fun::findOne($id);
        $fun->upViews();
        $this->save($fun);
        return $fun;
    }

    public function getByLegal($legal_id): array
    {
        return Fun::find()->andWhere(['legal_id' => $legal_id])->all();
    }

    public function getByAdminList($user_id)
    {
        return Fun::find()->active()->andWhere(['user_id' => $user_id])->orderBy(['name' => SORT_ASC])->all();
    }

    public function getByUser($user_id)
    {
        return Fun::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAll(): DataProviderInterface
    {
        $query = Fun::find()->alias('f')->active('f');
        return $this->getProvider($query);
    }

    public function search(SearchFunForm $form = null): DataProviderInterface
    {
        $query = Fun::find()->alias('f')->active('f')->with('type', 'mainPhoto');
        if ($form == null) {

            $query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.fun_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
            $query->groupBy('f.id');
            return $this->getProvider($query);
        }
        /******  Поиск по Категории ***/
        if ($form->type) {
            if ($category = Type::findOne($form->type)) {
                $query->andWhere(['f.type_id' => $form->type]);
            }
        }
        /******  Поиск по Дате ***/
        if ($form->date_from == null) $form->date_from = date('d-m-Y', time());
        if ($form->date_from || $form->date_to) {
            $query->joinWith(['actualCalendar ac']);
            if ($form->date_from) $query->andWhere(['>=', 'ac.fun_at', strtotime($form->date_from . '00:00:00')]);
            if ($form->date_to) $query->andWhere(['<=', 'ac.fun_at', strtotime($form->date_to . '23:59:00')]);
        }
        /******  Поиск по Наименованию ***/
        if (!empty($form->text)) {
            $form->text = trim(htmlspecialchars($form->text));
            $words = explode(' ', $form->text);
            foreach ($words as $word) {
                $query->andWhere(['like', 'name', $word]);
            }
        }

        $query->groupBy('f.id');
        return $this->getProvider($query);

    }

    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Fun::find()->alias('f')->active('f')->with('mainPhoto', 'type');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['f.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('f.id');
        return $this->getProvider($query);
    }

    public function save(Fun $fun)
    {
        if (!$fun->save()) {
            throw new \RuntimeException('Развлечение не сохранено');
        }
    }

    public function remove(Fun $fun)
    {
        if (!$fun->delete()) {
            throw new \RuntimeException('Ошибка удаления Развлечения');
        }
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['f.public_at' => SORT_DESC], 'desc' => ['f.public_at' => SORT_ASC],
                        ],
                        'name' => [
                            'asc' => ['f.name' => SORT_ASC], 'desc' => ['f.name' => SORT_DESC],
                        ],
                        'date' => [
                            'asc' => ['f.created_at' => SORT_ASC], 'desc' => ['f.created_at' => SORT_DESC],
                        ],
                        'cost' => [
                            'asc' => ['f.cost_adult' => SORT_ASC], 'desc' => ['f.cost_adult' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['f.rating' => SORT_ASC], 'desc' => ['f.rating' => SORT_DESC],
                        ],

                    ],
                ],
                'pagination' => [
                    'defaultPageSize' => \Yii::$app->params['paginationFun'],
                    'pageSizeLimit' => [\Yii::$app->params['paginationFun'], \Yii::$app->params['paginationFun']],
                ],
            ]
        );
    }

    public function findBySlug($slug)
    {
        $fun = Fun::find()->andWhere(['slug' => $slug])->one();
        $fun->upViews();
        $this->save($fun);
        return $fun;
    }

    public function find($id):? Fun
    {
        return Fun::findOne($id);
    }

}