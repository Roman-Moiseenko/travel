<?php


namespace booking\forms\user;


use booking\entities\user\UserMailing;
use yii\base\Model;

class UserMailingForm extends Model
{
    public $new_tours;
    public $new_cars;
    public $new_stays;
    public $new_funs;
    public $new_promotions;
    public $news_blog;

    public function __construct(UserMailing $mailing, $config = [])
    {
        $this->new_tours = $mailing->new_tours;
        $this->new_cars = $mailing->new_cars;
        $this->new_stays = $mailing->new_stays;
        $this->new_funs = $mailing->new_funs;
        $this->new_promotions = $mailing->new_promotions;
        $this->news_blog = $mailing->news_blog;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['new_tours', 'new_cars', 'new_stays', 'new_funs', 'new_promotions', 'news_blog'], 'boolean'],
        ];
    }
}