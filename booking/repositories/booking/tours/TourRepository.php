<?php


namespace booking\repositories\booking\tours;

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\booking\tours\SearchToursForm;
use booking\helpers\scr;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class TourRepository
{
    public function get($id)
    {
        return Tour::findOne($id);
    }

    public function getByUser($user_id)
    {
        return Tour::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAll(): DataProviderInterface
    {
        $query = Tour::find()->alias('t');
        return$this->getProvider($query);
    }

    public function search(SearchToursForm $form = null): DataProviderInterface
    {
        $query = Tour::find()->alias('t')->with('type', 'mainPhoto');
        if ($form == null) {
            $query->joinWith(['actualCalendar ac']);
            $query->andWhere(['>=', 'ac.tour_at', strtotime(date('d-m-Y', time()) . '00:00:00')]);
            $query->groupBy('t.id');
            return $this->getProvider($query);
        }
        /******  Поиск по Категории ***/
        if ($form->type) {
            if ($category = Type::findOne($form->type)) {
                $query->joinWith(['typeAssignments ta'], false);
                $query->andWhere(['or', ['t.type_id' => $form->type], ['ta.type_id' => $form->type]]);
            }
        }
        /******  Поиск по Дате ***/
        if ($form->date_from == null) $form->date_from = date('d-m-Y', time());
        if ($form->date_from || $form->date_to) {
            $query->joinWith(['actualCalendar ac']);
            if ($form->date_from) $query->andWhere(['>=', 'ac.tour_at', strtotime($form->date_from . '00:00:00')]);
            if ($form->date_to) $query->andWhere(['<=', 'ac.tour_at', strtotime($form->date_to . '23:59:00')]);
        }
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
        //var_dump($form->private); exit();
        if ($form->private !== "") {
            $query->andWhere(['t.params_private' => $form->private]);
        }
        $query->groupBy('t.id');
        //scr::p($form);
        return $this->getProvider($query);
        /*
        $pagination = new Pagination([
            'pageSizeLimit' => [15, 100],
            'validatePage' => false,
        ]);
        $sort = new Sort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id',
                'name',
                'price',
                'rating',
            ],
        ]);
        $response = $this->client->search([
            'index' => 'shop',
            'type' => 'products',
            'body' => [
                '_source' => ['id'],
                'from' => $pagination->getOffset(),
                'size' => $pagination->getLimit(),
                'sort' => array_map(function ($attribute, $direction) {
                    return [$attribute => ['order' => $direction === SORT_ASC ? 'asc' : 'desc']];
                }, array_keys($sort->getOrders()), $sort->getOrders()),
                'query' => [
                    'bool' => [
                        'must' => array_merge(
                            array_filter([
                                !empty($form->category) ? ['term' => ['categories' => $form->category]] : false,
                                !empty($form->brand) ? ['term' => ['brand' => $form->brand]] : false,
                                !empty($form->text) ? ['multi_match' => [
                                    'query' => $form->text,
                                    'fields' => [ 'name^3', 'description' ]
                                ]] : false,
                            ]),
                            array_map(function (ValueForm $value) {
                                return ['nested' => [
                                    'path' => 'values',
                                    'query' => [
                                        'bool' => [
                                            'must' => array_filter([
                                                ['match' => ['values.characteristic' => $value->getId()]],
                                                !empty($value->equal) ? ['match' => ['values.value_string' => $value->equal]] : false,
                                                !empty($value->from) ? ['range' => ['values.value_int' => ['gte' => $value->from]]] : false,
                                                !empty($value->to) ? ['range' => ['values.value_int' => ['lte' => $value->to]]] : false,
                                            ]),
                                        ],
                                    ],
                                ]];
                            }, array_filter($form->values, function (ValueForm $value) { return $value->isFilled(); }))
                        )
                    ],
                ],
            ],
        ]);
        $ids = ArrayHelper::getColumn($response['hits']['hits'], '_source.id');
        if ($ids) {
            $query = Product::find()
                ->NotEmpty()
                ->with('mainPhoto')
                ->andWhere(['id' => $ids])
                ->orderBy(new Expression('FIELD(id,' . implode(',', $ids) . ')'));
        } else {
            $query = Product::find()->andWhere(['id' => 0]);
        }
        return new SimpleActiveDataProvider([
            'query' => $query,
            'totalCount' => $response['hits']['total'],
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
*/
    }

    public function getAllByType(Type $type): DataProviderInterface
    {
        $query = Tour::find()->alias('t')->active('t')->with('mainPhoto', 'type');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['t.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function save(Tour $tours)
    {
        if (!$tours->save()) {
            throw new \RuntimeException('Тур не сохранен');
        }
    }

    public function remove(Tour $tours)
    {
        if (!$tours->delete()) {
            throw new \RuntimeException('Ошибка удаления Тура');
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
                            'asc' => ['t.id' => SORT_ASC], 'desc' => ['t.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['t.name' => SORT_ASC], 'desc' => ['t.name' => SORT_DESC],
                        ],
                        /*'price' => [
                            'asc' => ['p.price_new' => SORT_ASC], 'desc' => ['p.price_new' => SORT_DESC],
                        ],*/
                        'rating' => [
                            'asc' => ['t.rating' => SORT_ASC], 'desc' => ['t.rating' => SORT_DESC],
                        ],

                    ],
                ],
                'pagination' => [
                    'defaultPageSize' => 15,
                    'pageSizeLimit' => [15, 100],
                ],
            ]
        );
    }
}