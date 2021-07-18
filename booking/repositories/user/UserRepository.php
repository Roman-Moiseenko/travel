<?php

namespace booking\repositories\user;

use booking\entities\Lang;
use booking\entities\mailing\Mailing;
use booking\entities\user\User;
use booking\entities\user\UserMailing;
use booking\helpers\scr;

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

    public function save(User $user): bool
    {
        if (!$user->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения'));
        }
        return true;
    }

    public function findByNetworkIdentity($network, $identity)
    {
        return User::find()
            ->joinWith('networks n')
            ->andWhere(['n.network' => $network, 'n.identity' => $identity])
            ->one();
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
            throw new \DomainException(Lang::t('Ошибка удаления'));
        }
    }

    public function getAllEmail($type_mailing = null)
    {
        $result = User::find()->alias('u')->select('u.email')->andWhere(['<>', 'u.email', '']);
        if ($type_mailing) {
            $field = '';
            switch ($type_mailing) {
                case Mailing::NEW_TOURS: $field = 'new_tours'; break;
                case Mailing::NEW_CARS: $field = 'new_cars'; break;
                case Mailing::NEW_STAYS: $field = 'new_stays'; break;
                case Mailing::NEW_FUNS: $field = 'new_funs'; break;
                case Mailing::PROMOTIONS: $field = 'new_promotions'; break;
                case Mailing::NEWS_BLOG: $field = 'news_blog'; break;
            }
            $result = $result->leftJoin(UserMailing::tableName() . ' m', 'm.user_id = u.id')->andWhere(['m.'.$field => true]);
        }
        return $result->asArray()->column();
    }

    public function getMask(array $array)
    {
        return User::find()->andWhere($array)->all();
    }

}