<?php


namespace booking\repositories\booking\cars;


use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\CostCalendar;
use booking\entities\booking\cars\Type;
use booking\entities\booking\cars\Value;
use booking\entities\booking\City;
use booking\forms\booking\cars\SearchCarForm;
use booking\helpers\scr;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class CarRepository
{
    public function get($id)
    {
        return Car::findOne($id);
    }

    public function getByLegal($legal_id): array
    {
        return Car::find()->andWhere(['legal_id' => $legal_id])->all();
    }

    public function getByAdminList($user_id)
    {
        return Car::find()->active()->andWhere(['user_id' => $user_id])->orderBy(['name' => SORT_ASC])->all();
    }

    public function getByUser($user_id)
    {
        return Car::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAll(): DataProviderInterface
    {
        $query = Car::find()->alias('c')->active('c');
        return $this->getProvider($query);
    }

    public function search(SearchCarForm $form = null): DataProviderInterface
    {
        $query = Car::find()->alias('c')->active('c')->with('type', 'mainPhoto');
        if ($form == null) {

            $query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.car_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
            $query->groupBy('c.id');
            return $this->getProvider($query);
        }
        /******  Поиск по Категории ***/
        if ($form->type) {
            if ($category = Type::findOne($form->type)) {
                $query->andWhere(['c.type_id' => $form->type]);
            }
        }
        /******  Поиск по Дате ***/
        $query->joinWith(['actualCalendar ac']);
        if ($form->date_from == null) $query->andWhere(['>=', 'ac.car_at', time()]);
        if ($form->date_from && $form->date_to == null) {
            if ($form->date_from) $query->andWhere(['=', 'ac.car_at', strtotime($form->date_from . '00:00:00')]);
        }
        if ($form->date_from && $form->date_to) {
            //Проходим каждый день, есть ли на этот день свободные авто
            $_count_days = ((strtotime($form->date_to) - strtotime($form->date_from)) / (3600 * 24));
            //Находим на первый день - эталонный массив
            $car_ids = $this->carIds(CostCalendar::find()->andWhere(['car_at' => strtotime($form->date_from)])->groupBy(['car_id'])->all());
            for ($i = 1; $i <= $_count_days; $i++) {
                $_car_ids = $this->carIds(CostCalendar::find()->andWhere(['car_at' => strtotime($form->date_from) + $i * 3600 * 24])->groupBy(['car_id'])->all());
                //Ищем несоответствия за каждый день с  эталоном
                $sub = array_diff($_car_ids, $car_ids);
                //Удаляем из эталона несоответствия
                if (!empty($sub)) {
                    foreach ($sub as $item) {
                        unset($car_ids[$item]);
                    }
                }
                //Обратная проверка
                $sub = array_diff($car_ids, $_car_ids);
                if (!empty($sub)) {
                    foreach ($sub as $item) {
                        unset($car_ids[$item]);
                    }
                }
            }
            $query->andWhere(['IN', 'c.id', $car_ids]);
        }
        /******  Поиск по Городу ***/
        if ($form->city) {
            if ($city = City::findOne($form->city)) {
                $query->joinWith(['assignmentCities city']);
                $query->andWhere(['city.city_id' => $form->city]);
            }
        }

        /***** Поиск по Характеристикам ***/
        if ($form->values) {
            $car_ids = null;
            foreach ($form->values as $value) {
                if ($value->isFilled()) {
                    $q = Value::find()->andWhere(['characteristic_id' => $value->getId()]);
                    $q->andFilterWhere(['>=', 'CAST(value AS SIGNED)', $value->from]);
                    $q->andFilterWhere(['<=', 'CAST(value AS SIGNED)', $value->to]);
                    $q->andFilterWhere(['value' => $value->equal]);
                    $foundIds = $q->select('car_id')->column();
                    $car_ids = $car_ids === null ? $foundIds : array_intersect($car_ids, $foundIds);
                }
            }
            if ($car_ids !== null) {
                $query->andWhere(['c.id' => $car_ids]);
            }
        }
        $query->groupBy('c.id');
        return $this->getProvider($query);
    }

    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Car::find()->alias('с')->active('с')->with('mainPhoto', 'type');
        $query->andWhere(['c.type_id' => $type->id]);
        $query->groupBy('с.id');
        return $this->getProvider($query);
    }

    public function save(Car $car)
    {
        if (!$car->save()) {
            throw new \RuntimeException('Авто не сохранено');
        }
    }

    public function remove(Car $car)
    {
        if (!$car->delete()) {
            throw new \RuntimeException('Ошибка удаления Авто');
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
                            'asc' => ['c.public_at' => SORT_ASC], 'desc' => ['c.public_at' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['c.name' => SORT_ASC], 'desc' => ['c.name' => SORT_DESC],
                        ],
                        'date' => [
                            'asc' => ['c.created_at' => SORT_ASC], 'desc' => ['c.created_at' => SORT_DESC],
                        ],
                        'cost' => [
                            'asc' => ['c.cost' => SORT_ASC], 'desc' => ['c.cost' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['c.rating' => SORT_ASC], 'desc' => ['c.rating' => SORT_DESC],
                        ],

                    ],
                ],
                'pagination' => [
                    'defaultPageSize' => \Yii::$app->params['paginationCar'],
                    'pageSizeLimit' => [\Yii::$app->params['paginationCar'], \Yii::$app->params['paginationCar']],
                ],
            ]
        );
    }

    public function findBySlug($slug)
    {
        $car = Car::find()->andWhere(['slug' => $slug])->one();
        $car->upViews();
        $this->save($car);
        return $car;
    }

    public function find($id): ?Car
    {
        $car = Car::findOne($id);
        $car->upViews();
        $this->save($car);
        return $car;
    }

    private function carIds($costCalendars): array
    {
        $car_ids = [];
        foreach ($costCalendars as $calendar) {
            if ($calendar->getFreeCount() != 0)
                $car_ids[$calendar->car_id] = $calendar->car_id;
        }
        return $car_ids;
    }

}