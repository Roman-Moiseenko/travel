<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\Tours;
use booking\entities\booking\tours\Type;
use Prophecy\Argument\Token\TypeToken;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class ToursRepository
{
    public function get($id)
    {
        return Tours::findOne($id);
    }

    public function getByUser($user_id)
    {
        return Tours::find()->andWhere(['user_id' => $user_id])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAll(): DataProviderInterface
    {
        $query = Tours::find()->alias('t');
        return$this->getProvider($query);
    }

    ///TODO
    public function search(SearchToursForm $form): DataProviderInterface
    {
        $query = Tours::find()->alias('t')/*->NotEmpty('p')*/->with('type', 'mainPhoto');


        if ($form->type) {
            if ($category = Type::findOne($form->type)) {
                $query->joinWith(['typeAssignments ta'], false);
                $query->andWhere(['or', ['t.type_id' => $form->type], ['ca.type_id' => $form->type]]);
                $query->groupBy('t.id');

            }
        }

        /******  Поиск по наименованию ***/
        if (!empty($form->text)) {
            $form->text = trim(htmlspecialchars($form->text));
            $words = explode(' ', $form->text);
            foreach ($words as $word) {
                $query->andWhere(['like', 'name', $word]);
            }
        }
        $query->groupBy('t.id');
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
        $query = Tours::find()->alias('t')->active('t')->with('mainPhoto', 'type');
        $query->joinWith(['typeAssignments ta'], false);
        $query->andWhere(['or', ['t.type_id' => $type->id], ['ca.type_id' => $type->id]]);
        $query->groupBy('t.id');
        return $this->getProvider($query);
    }

    public function save(Tours $tours)
    {
        if (!$tours->save()) {
            throw new \RuntimeException('Тур не сохранен');
        }
    }

    public function remove(Tours $tours)
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