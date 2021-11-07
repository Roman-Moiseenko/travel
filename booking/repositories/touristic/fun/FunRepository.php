<?php


namespace booking\repositories\touristic\fun;


use booking\entities\touristic\fun\Fun;
use booking\helpers\StatusHelper;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class FunRepository
{
    public function get($id)
    {
        return Fun::findOne($id);
    }


    public function getAllByCategory($category_id): DataProviderInterface
    {
        $query = Fun::find()->andWhere(['category_id' => $category_id])->andWhere(['status' => StatusHelper::STATUS_ACTIVE]);
        return $this->getProvider($query);
    }

    public function save(Fun $fun)
    {
        if (!$fun->save()) {
            throw new \DomainException('Развлечение не сохранено');
        }
    }

    public function remove(Fun $fun)
    {
        if (!$fun->delete()) {
            throw new \DomainException('Ошибка удаления Развлечения');
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
                            'asc' => ['f.public_at' => SORT_ASC], 'desc' => ['f.public_at' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['f.name' => SORT_ASC], 'desc' => ['f.name' => SORT_DESC],
                        ],
                        'date' => [
                            'asc' => ['f.created_at' => SORT_ASC], 'desc' => ['f.created_at' => SORT_DESC],
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

    public function getAllForSitemap()
    {
        return Fun::find()->active()->all();
    }

}