<?php

namespace booking\forms\booking\stays;

use booking\entities\booking\stays\Review;
use yii\base\Model;

class ReviewEditForm extends Model
{
    public $vote;
    public $text;

    public function __construct(Review $review, $config = [])
    {
        $this->vote = $review->vote;
        $this->text = $review->text;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['vote', 'text'], 'required'],
            [['vote'], 'in', 'range' => [1, 2, 3, 4, 5]],
            ['text', 'string'],
        ];
    }
}