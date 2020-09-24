<?php


namespace office\forms;


use booking\entities\user\User;
use yii\data\ActiveDataProvider;

class ClientsSearch extends User
{
    public $id;
    public $username;
    public $email;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'email'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()->alias('u');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {

            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'u.id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email]);
        return $dataProvider;
    }
}