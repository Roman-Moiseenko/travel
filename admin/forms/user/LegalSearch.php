<?php


namespace admin\forms\user;


use booking\entities\admin\user\UserLegal;
use yii\data\ActiveDataProvider;

class LegalSearch extends UserLegal
{
    public function rules()
    {
        return [
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = UserLegal::find()->andWhere(['user_id' => \Yii::$app->user->id]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}