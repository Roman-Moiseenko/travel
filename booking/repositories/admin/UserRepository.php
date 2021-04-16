<?php

namespace booking\repositories\admin;

use booking\entities\admin\Debiting;
use booking\entities\admin\Deposit;
use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\Lang;
use booking\helpers\scr;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class UserRepository
{

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['verification_token' => $token]);
    }

    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByUsernameEmail($value):? User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function getByUsername($username): User
    {
        return $this->getBy(['username' => $username]);
    }
    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения'));
        }
    }

    public function getByLegal($id): User

    {
        return User::find()->andWhere(['id' => Legal::find()->select('user_id')->andWhere(['id' => $id])])->one();
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::findOne($condition)) {
            throw new \DomainException(Lang::t('Пользователь не найден'));
        }
        return $user;
    }

    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \DomainException('Ошибка удаления');
        }
    }

    public function getAllEmail()
    {
        return User::find()->select(['email'])->andWhere(['status' => User::STATUS_ACTIVE])->asArray()->column();
    }

    public function searchDeposit($user_id, $search = null): DataProviderInterface
    {
        $query = Deposit::find()->andWhere(['user_id' => $user_id]);
        return $this->getProvider($query);
    }

    public function searchDebiting($user_id, $search = null): DataProviderInterface
    {
        $query = Debiting::find()->andWhere(['user_id' => $user_id]);
        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
               /* 'attributes' => [
                    'amount' => [
                        'asc' => ['amount' => SORT_ASC], 'desc' => ['amount' => SORT_DESC],
                    ],
                    'date' => [
                        'asc' => ['created_at' => SORT_ASC], 'desc' => ['created_at' => SORT_DESC],
                    ],
                ],*/
            ],
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [30, 30],
            ],
        ]);
    }

}