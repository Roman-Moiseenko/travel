<?php


namespace booking\repositories\moving;


use booking\entities\moving\FAQ;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class FAQRepository
{

    public function SearchModel($category_id): DataProviderInterface
    {
        $all = FAQ::find()->andWhere(['category_id' => $category_id]);
        return $this->getProvider($all);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSizeLimit' => [10, 10],
            ],
        ]);
    }

    public function get($id): FAQ
    {
        if (!$faq = FAQ::findOne($id)) {
            throw new \DomainException('Вопрос не найден');
        }
        return $faq;
    }

    public function save(FAQ $faq)
    {
        if (!$faq->save()) {
            throw new \DomainException('Вопрос не сохранен');
        }
    }
}