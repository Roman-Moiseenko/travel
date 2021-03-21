<?php


namespace booking\forms\booking;


use booking\entities\booking\BaseReview;
use booking\entities\Lang;
use yii\base\Model;

class ReviewForm extends Model
{



    public $vote;
    public $text;

    public function __construct(BaseReview $review = null, $config = [])
    {
        if ($review != null)
        {
            $this->vote = $review->getVote();
            $this->text = $review->getText();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['vote', 'text'], 'required', 'message' => 'Обязательное поле'],
            [['vote'], 'in', 'range' => $this->voteList()],
            ['text', 'string'],
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