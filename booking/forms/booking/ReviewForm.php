<?php


namespace booking\forms\booking;


use booking\entities\booking\ReviewInterface;
use frontend\widgets\RatingWidget;
use yii\base\Model;

class ReviewForm extends Model
{



    public $vote;
    public $text;

    public function __construct(ReviewInterface $review = null, $config = [])
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
            [['vote', 'text'], 'required'],
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
}