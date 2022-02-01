<?php

namespace booking\repositories\booking\tours;

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\scr;
use booking\helpers\StatusHelper;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class TourRepository
{
    public function get($id)
    {
        if (!$result = Tour::findOne($id)) {
            throw new \DomainException('Тур не найден');
        }
        return $result;
    }

    public function getByLegal($legal_id): array
    {
        return Tour::find()->active()->andWhere(['legal_id' => $legal_id])->all();
    }

    public function getByAdminList($user_id)
    {
        return Tour::find()->active()->andWhere(['user_id' => $user_id])->orderBy(['name' => SORT_ASC])->all();
    }

    public function getByUser($user_id)
    {
        return Tour::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function getAllForSitemap()
    {
        return Tour::find()->active()->all();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Tour::find()->alias('t')->active('t');
        return $this->getProvider($query);
    }

    public function search(SearchTourForm $form = null): DataProviderInterface
    {
        $query = Tour::find()->alias('t')->active('t')->with('type', 'mainPhoto');
        if ($form == null) {
            return $this->getProvider($query);
            /*$query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.tour_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
            $query->groupBy('t.id');
            return $this->getProvider($query);*/
        }
        /******  Поиск по Категории ***/
        if ($form->type) {
            if ($category = Type::findOne($form->type)) {
                $query->joinWith(['typeAssignments ta'], false);
                $query->andWhere(['or', ['t.type_id' => $form->type], ['ta.type_id' => $form->type]]);
            }
        }
        /******  Поиск по Дате ***/
      /*  if ($form->date_from == null) $form->date_from = date('d-m-Y', time());
        if ($form->date_from || $form->date_to) {
            //TODO Стек проверить
            $query->joinWith(['actualCalendar ac']);
            if ($form->date_from) $query->andWhere(['>=', 'ac.tour_at', strtotime($form->date_from . '00:00:00')]);
            if ($form->date_to) $query->andWhere(['<=', 'ac.tour_at', strtotime($form->date_to . '23:59:00')]);
        }*/
        /******  Поиск по Наименованию ***/
        if (!empty($form->text)) {
            $form->text = trim(htmlspecialchars($form->text));
            $words = explode(' ', $form->text);
            foreach ($words as $word) {
                $query->andWhere(['like', 'name', $word]);
            }
        }
        /******  Поиск по Цене ***/
        if ($form->cost_min) {
            $query->andWhere(['>=', 't.cost_adult', $form->cost_min]);
        }
        if ($form->cost_max) {
            $query->andWhere(['<=', 't.cost_adult', $form->cost_max]);
        }

        /******  Поиск по Типу ***/
        if ($form->private !== "" && $form->private !== null) {
            $query->andWhere(['t.params_private' => $form->private]);
        }
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Tour::find()->alias('t')->active('t')->with('mainPhoto', 'type');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['t.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function save(Tour $tour)
    {
        if (!$tour->save()) {
            throw new \DomainException('Тур не сохранен');
        }
    }

    public function remove(Tour $tour)
    {
        if (!$tour->delete()) {
            throw new \DomainException('Ошибка удаления Тура');
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
        $tour = Tour::find()->andWhere(['slug' => $slug])->one();
        if (empty($tour))
            throw new NotFoundHttpException(Lang::t('Неверный адрес') . ': ' . $slug);
        return $tour;
    }

    public function find($id): ?Tour
    {
        return Tour::findOne($id);
    }

}