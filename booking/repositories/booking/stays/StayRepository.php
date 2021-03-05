<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\Type;
use booking\entities\Lang;
use booking\forms\booking\stays\search\SearchStayForm;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\db\ArrayExpression;
use yii\db\Expression;
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
        $query = Stay::find()->alias('t')->active('t')->select('t.*')->with('type', 'mainPhoto');
        if ($form == null) {
            $query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.stay_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
            $query->groupBy('t.id');
            return $this->getProvider($query);
        }

        $ids = [];
        /******  Поиск по Гостям и детям ***/
        if ($form->children == 0) {
            $query->andWhere(['>=', 'params_guest', $form->guest]);
        } else {
            $query->joinWith(['rules rl']);
            $guest = $form->guest;
            $child_min = 16;
            //Определяем минимальный возраст ребенка из form
            for ($i = 1; $i <= 8; $i++) {
                if ($form->children_age[$i] == "") {
                    if ($i <= $form->children) \Yii::$app->session->setFlash('warning', 'Не указан возраст ребенка');
                } else {
                    $child_min = min($child_min, $form->children_age[$i]);
                }
            }
            $query->andWhere(['rl.limit_children' => true]);
            $query->andWhere(['<=', 'rl.limit_children_allow', $child_min]);
            $query->andWhere(['>=', 'params_guest', $guest]);
        }

        /******  Поиск по Кол-во спален ***/
        $bedrooms = [];
        foreach ($form->bedrooms as $item) {
            if ($item->checked) $bedrooms[] = $item->id;
        }
        if (count($bedrooms) > 0) {
            $query2 = Stay::find()->alias('t')->active('t')->select('t.id');
            $query2->joinWith(['bedrooms rooms']);
            if ($bedrooms[0] == 1) {
                $query2->having(' COUNT(rooms.stay_id) = 1');
            } else {
                $query2->having(' COUNT(rooms.stay_id) >= ' . (int)$bedrooms[0]);
            }
            $query2->groupBy('t.id');
            $ids[] = $query2->column();
            //scr::p($ids);
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

        /******  Поиск по Удобства  ***/
      $comforts_ids = [];
        foreach ($form->comforts as $comfort) {
            if ($comfort->checked) {
                $comforts_ids[] = $comfort->id;
            }
        }

        if (count($comforts_ids) != 0) {
            $query2 = Stay::find()->alias('t')->active('t')->select('t.id');
            $query2->joinWith(['assignComforts cm']);
            $query2->andWhere(['IN', 'cm.comfort_id', $comforts_ids]);
            $query2->having('count(cm.comfort_id) = ' . count($comforts_ids));
            $query2->groupBy('t.id');
            $ids[] = $query2->column();
        }

        /******  Поиск по Удобства в номерах  ***/
        $comforts_room_ids = [];
        foreach ($form->comforts_room as $comfort_room) {
            if ($comfort_room->checked) {
                $comforts_room_ids[] = $comfort_room->id;
            }
        }

        if (count($comforts_room_ids)) {
            $query2 = Stay::find()->alias('t')->active('t')->select('t.id');
            $query2->joinWith(['assignComfortsRoom cmr']);
            $query2->andWhere(['IN', 'cmr.comfort_id', $comforts_room_ids]);
            $query2->having('count(cmr.comfort_id) = ' . count($comforts_room_ids));
            $query2->groupBy('t.id');
            $ids[] = $query2->column();
        }

        /******  Поиск по Дате ***/

        if ($form->date_from && $form->date_to) {
            $query2 = Stay::find()->alias('t')->active('t')->select('t.id');
            $query2->joinWith(['actualCalendar ac']);
            $begin = SysHelper::_renderDate($form->date_from);
            $end = SysHelper::_renderDate($form->date_to);
            $dates = []; //Массив дней из диапозона
            for ($date = $begin; $date < $end; $date += 24 * 60 * 60) {
                $dates[] = $date;
            }
            $query2->andWhere(['IN', 'ac.stay_at', $dates]);
            $query2->having('count(ac.stay_at) = ' . count($dates)); //кол-во выбранных дней должно совпадать с кол-вом запрошенных дней
            $query2->groupBy('t.id');
            $ids[] = $query2->column();
        } else {
            $query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.stay_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
        }

        /******  Поиск по Наименованию Городу ***/
       if (!empty($form->city)) {
            $form->city = trim(htmlspecialchars($form->city));
            $query->andWhere(['like', 'city', $form->city]);
        }


        /******  Поиск по Цене ***/
        //TODO на будущее

        /*     if ($form->cost_min) {
                 $query->andWhere(['>=', 't.cost_base', $form->cost_min]);
             }
             if ($form->cost_max) {
                 $query->andWhere(['<=', 't.cost_base', $form->cost_max]);
             }
     */
        if (count($ids) == 1) {
            $query->andWhere(['IN', 't.id', $ids[0]]);
        }
        if (count($ids) > 1) {
            $id = array_intersect(...$ids);
            $query->andWhere(['IN', 't.id', $id]);
        }
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
                        'asc' => ['t.cost_base' => SORT_ASC], 'desc' => ['t.cost_base' => SORT_DESC],
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