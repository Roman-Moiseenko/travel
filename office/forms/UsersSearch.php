<?php


namespace office\forms;


use booking\entities\office\User;
use yii\data\ActiveDataProvider;

class UsersSearch extends User
{
    public $id;
    public $role;
    public $username;
    public $email;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'role'], 'safe'],
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
            'u.status' => $this->status,
        ]);

        if (!empty($this->role)) {
            $query->innerJoin('{{%auth_assignments}} a', 'a.user_id = u.id');
            $query->andWhere(['a.item_name' => $this->role]);
        }
        $query
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email]);
        return $dataProvider;
    }
}