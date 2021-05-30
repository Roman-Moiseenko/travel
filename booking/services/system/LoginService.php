<?php


namespace booking\services\system;


use booking\entities\user\User;

class LoginService
{
    public function isGuest(): bool
    {
        return \Yii::$app->user->isGuest;
    }

    public function user():? User
    {
        if ($this->isGuest()) return null;
        $user = \Yii::$app->user->identity;
        if ($user instanceof User) return $user;
        throw new \DomainException('Ошибка класса User. Должен быть Frontend');
    }

    public function admin():? \booking\entities\admin\User
    {
        if ($this->isGuest()) return null;
        $user = \Yii::$app->user->identity;
        if ($user instanceof \booking\entities\admin\User) return $user;
        throw new \DomainException('Ошибка класса User. Должен быть Admin');
    }

    public function office():? \booking\entities\office\User
    {
        if ($this->isGuest()) return null;
        $user = \Yii::$app->user->identity;
        if ($user instanceof \booking\entities\office\User) return $user;
        throw new \DomainException('Ошибка класса User. Должен быть Office');
    }

    public function check():? \booking\entities\check\User
    {
        if ($this->isGuest()) return null;
        $user = \Yii::$app->user->identity;
        if ($user instanceof \booking\entities\check\User) return $user;
        throw new \DomainException('Ошибка класса User. Должен быть Check');
    }

    public function currentClass(): string
    {
        return get_class(\Yii::$app->user->identity);
    }

    public function isFor($id): bool
    {
        return \Yii::$app->user->id == $id;
    }
}