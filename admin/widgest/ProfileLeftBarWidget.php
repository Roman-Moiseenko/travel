<?php


namespace admin\widgest;


use booking\entities\admin\User;
use booking\repositories\admin\UserRepository;
use yii\base\Widget;
use yii\helpers\Url;

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
        /** @var User $user */
        $user = $this->users->get(\Yii::$app->user->id);
        if ($user->personal->photo != null) {
            $photo = $user->personal->getThumbFileUrl('photo', 'cart_list');
        } else {
            $photo = \Yii::$app->params['staticHostInfo'] . '/files/images/user.jpg';
        }
        if ($user->personal->fullname->firstname == '') {
            $userName = $user->username;
        } else {
            $userName = $user->personal->fullname->getShortname();
        }
        return $this->render('profile_left_bar', [
            'user' => $user,
            'userImage' => $photo,
            'userName' => $userName,
        ]);
    }
}