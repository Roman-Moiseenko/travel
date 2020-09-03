<?php

namespace admin\forms;

use booking\entities\booking\Discount;
use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class DiscountSearch extends Discount
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Discount::find()->andWhere(['user_id' => \Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
