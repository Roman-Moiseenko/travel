<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\Type;
use booking\entities\Lang;
use booking\forms\booking\stays\search\SearchStayForm;
use booking\helpers\scr;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class StayRepository
{

    public function get($id)
    {
        if (!$result = Stay::findOne($id)) {
            throw new \DomainException('Жилище не найдено');
        }
        return $result;
    }

    public function getByLegal($legal_id): array
    {
        return Stay::find()->active()->andWhere(['legal_id' => $legal_id])->all();
    }


    public function getByAdminList($user_id)
    {
        return Stay::find()->active()->andWhere(['user_id' => $user_id])->orderBy(['name' => SORT_ASC])->all();
    }


    public function getByUser($user_id)
    {
        return Stay::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAllForSitemap()
    {
        return Stay::find()->active()->all();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Stay::find()->alias('t')->active('t');
        return $this->getProvider($query);
    }

    public function search(SearchStayForm $form = null): DataProviderInterface
    {
        $query = Stay::find()->alias('t')->active('t')->with('type', 'mainPhoto');
        if ($form == null) {

            $query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.stay_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
            $query->groupBy('t.id');
            return $this->getProvider($query);
        }

        /******  Поиск по Кол-во спален ***/
        $bedrooms = [];
        foreach ($form->bedrooms as $item) {
            if ($item->checked) $bedrooms[] = $item->id;
        }
        if (count($bedrooms) > 0) {
            /*
            //$query->joinWith(['bedrooms b']);
            if ($bedrooms[0] == 1) {
                $query->andWhere([
                    $bedrooms[0] => AssignRoom::find()->alias('rr')->andWhere(['rr.stay_id' => new \yii\db\Expression('t.id')])->count('rr.id')]);
            } else {
                $query->andWhere(['<=', $bedrooms[0], AssignRoom::find()->alias('rr')->andWhere(['rr.stay_id' => new \yii\db\Expression('t.id')])->count('rr.id')]);
            }
*/
        }

        /******  Поиск по Растояние до центра ***/
        $to_center_items = [];
        foreach ($form->to_center as $item) {
            if ($item->checked) $to_center_items[] = $item->id;
        }
        if (count($to_center_items) > 0) {
            $query->andWhere(['<=', 't.to_center', $to_center_items[0]]);
        }

        /******  Поиск по Категории ***/
        $category_ids = [];
        foreach ($form->categories as $category) {
            if ($category->checked) {
                $category_ids[] = $category->id;
            }
        }
        if (count($category_ids) != 0) {
            $query->andWhere(['IN', 't.type_id', $category_ids]);
        }

        /******  Поиск по Дате ***/
        //if ($form->date_from == null) $form->date_from = date('d-m-Y', time());
        //НЕ РАБОТАЕТ!!!
        if ($form->date_from || $form->date_to) {
            $query->joinWith(['actualCalendar ac']);
            if ($form->date_from) $query->andWhere(['>=', 'ac.stay_at', strtotime(($form->date_from) ?? date('d-m-Y', time()) . '00:00:00')]);
            if ($form->date_to) $query->andWhere(['<=', 'ac.stay_at', strtotime($form->date_to . '23:59:00')]);
        }
        /******  Поиск по Наименованию ***/
        if (!empty($form->city)) {
            $form->city = trim(htmlspecialchars($form->city));
            $query->andWhere(['like', 'city', $form->city]);

        }
        /******  Поиск по Цене ***/
        /*     if ($form->cost_min) {
                 $query->andWhere(['>=', 't.cost_adult', $form->cost_min]);
             }
             if ($form->cost_max) {
                 $query->andWhere(['<=', 't.cost_adult', $form->cost_max]);
             }
     */
        /******  Поиск по Типу ***/

        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Stay::find()->alias('t')->active('t')->with('mainPhoto', 'type');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['t.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function save(Stay $stay)
    {
        if (!$stay->save()) {
            throw new \DomainException('Жилище не сохранено');
        }
    }

    public function remove(Stay $stay)
    {
        if (!$stay->delete()) {
            throw new \DomainException('Ошибка удаления Жилища');
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
                        'asc' => ['t.public_at' => SORT_ASC], 'desc' => ['t.public_at' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['t.name' => SORT_ASC], 'desc' => ['t.name' => SORT_DESC],
                    ],
                    'date' => [
                        'asc' => ['t.created_at' => SORT_ASC], 'desc' => ['t.created_at' => SORT_DESC],
                    ],
                    'cost' => [
                        'asc' => ['t.cost_adult' => SORT_ASC], 'desc' => ['t.cost_adult' => SORT_DESC],
                    ],
                    'rating' => [
                        'asc' => ['t.rating' => SORT_ASC], 'desc' => ['t.rating' => SORT_DESC],
                    ],

                ],
            ],
            'pagination' => [
                'defaultPageSize' => \Yii::$app->params['paginationTour'],
                'pageSizeLimit' => [\Yii::$app->params['paginationTour'], \Yii::$app->params['paginationTour']],
            ],
        ]);
    }

    public function findBySlug($slug)
    {
        $stay = Stay::find()->andWhere(['slug' => $slug])->one();
        if (empty($stay))
            throw new NotFoundHttpException(Lang::t('Неверный адрес') . ': ' . $slug);
        return $stay;
    }

    public function find($id): ?Stay
    {
        return Stay::findOne($id);
    }
}