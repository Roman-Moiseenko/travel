<?php


namespace admin\widgest;


use booking\repositories\admin\UserRepository;
use yii\base\Widget;

class ProfileLeftBarWidget extends Widget
{
    private $users;
    public function __construct(UserRepository $users, $config = [])
    {
        $this->users = $users;
        parent::__construct($config);
    }

    public function run()
    {
        $user = $this->users->get(\Yii::$app->user->id);
        return $this->render('profile_left_bar', [
            'user' => $user
        ]);
    }
}