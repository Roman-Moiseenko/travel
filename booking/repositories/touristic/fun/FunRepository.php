<?php


namespace booking\repositories\touristic\fun;


use booking\entities\touristic\fun\Fun;
use booking\helpers\scr;
use booking\helpers\StatusHelper;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class FunRepository
{
    public function get($id)
    {
        return Fun::findOne($id);
    }

    public function getAllByCategory($category_id): DataProviderInterface
    {
        $query = Fun::find()->andWhere(['category_id' => $category_id])->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->orderBy(['sort' => SORT_ASC]);
        return $this->getProvider($query);
    }

    /**
     * @return Fun[]
     */

    public function getAll($category_id)
    {
        return Fun::find()->andWhere(['category_id' => $category_id])->orderBy(['sort' => SORT_ASC])->all();
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
                /*'sort' => [
                    //'defaultOrder' => ['created_at' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['featured_at' => SORT_ASC], 'desc' => ['featured_at' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['name' => SORT_ASC], 'desc' => ['name' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['rating' => SORT_ASC], 'desc' => ['rating' => SORT_DESC],
                        ],
                    ],
                ],*/
                'pagination' => [
                    'defaultPageSize' => \Yii::$app->params['paginationFun'],
                    'pageSizeLimit' => [\Yii::$app->params['paginationFun'], \Yii::$app->params['paginationFun']],
                ],
            ]
        );
    }

    public function findBySlug($slug)
    {
        if (!$fun = Fun::find()->andWhere(['slug' => $slug])->one()) {
            throw new NotFoundHttpException();
        }
        return $fun;
    }

    public function find($id):? Fun
    {
        return Fun::findOne($id);
    }

    public function getAllForSitemap()
    {
        return Fun::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->all();
    }
    public function getMaxSort($category_id)
    {
        return Fun::find()->andWhere(['category_id' => $category_id])->max('sort');
    }


    public function getMinSort($category_id)
    {
        return Fun::find()->andWhere(['category_id' => $category_id])->min('sort');
    }
}