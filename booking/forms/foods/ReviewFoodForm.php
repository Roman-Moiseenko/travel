<?php


namespace booking\forms\foods;


use booking\entities\booking\BaseReview;
use booking\entities\foods\ReviewFood;
use booking\entities\Lang;
use yii\base\Model;

class ReviewFoodForm extends Model
{
    public $vote;
    public $text;
    public $email;
    public $username;

    public function __construct(ReviewFood $review = null, $config = [])
    {
        if ($review != null)
        {
            $this->vote = $review->vote;
            $this->text = $review->text;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['vote', 'text', 'email', 'username'], 'required', 'message' => 'Обязательное поле'],
            [['vote'], 'in', 'range' => $this->voteList()],
            [['text', 'email', 'username'], 'string'],
        ];
    }

    public function voteList()
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ];
    }
    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->vote == null)
            \Yii::$app->session->setFlash('error', Lang::t('Не указан рейтинг в отзыве'));
    }
}