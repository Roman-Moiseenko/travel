<?php


namespace office\forms;


use booking\entities\admin\Legal;
use booking\entities\mailing\Mailing;
use yii\data\ActiveDataProvider;

class MailingSearch extends Mailing
{

    public function rules()
    {
        return [
            [['id', 'theme'], 'integer'],

        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Mailing::find();
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
        $query->andFilterWhere([
            'id' => $this->id,
            'theme' => $this->theme,
        ]);
        return $dataProvider;
    }
}