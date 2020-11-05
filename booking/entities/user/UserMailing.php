<?php


namespace booking\entities\user;


use yii\db\ActiveRecord;

/**
 * Class UserMailing
 * @package booking\entities\user
 * @property integer $id
 * @property integer $user_id
 * @property bool $new_tours
 * @property bool $new_cars
 * @property bool $new_stays
 * @property bool $new_funs
 * @property bool $new_promotions
 * @property bool $news_blog
 */

class UserMailing extends ActiveRecord
{

    public static function create($new_tours = true, $new_cars = true, $new_stays = true, $new_funs = true, $new_promotions = true, $news_blog = true): self
    {
        $mailing = new static();
        $mailing->new_tours = $new_tours;
        $mailing->new_cars = $new_cars;
        $mailing->new_stays = $new_stays;
        $mailing->new_funs = $new_funs;
        $mailing->new_promotions = $new_promotions;
        $mailing->news_blog = $news_blog;
        return $mailing;
    }

    public function edit($new_tours, $new_cars, $new_stays, $new_funs, $new_promotions, $news_blog)
    {
        $this->new_tours = $new_tours;
        $this->new_cars = $new_cars;
        $this->new_stays = $new_stays;
        $this->new_funs = $new_funs;
        $this->new_promotions = $new_promotions;
        $this->news_blog = $news_blog;
    }

    public static function tableName()
    {
        return '{{%user_mailing}}';
    }
}