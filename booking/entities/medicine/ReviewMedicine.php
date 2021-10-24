<?php

//TODO Комментарии/отзывы к главной страницы по переезду
// добавляем ч/з каптчу или только для зарегистрированных (??)
// ставим датапровайдер и показываем только 20 комментов или показываем все, сворачиваем (?)
// делаем ответ на коммент?
// отсылаем вопрос модератору?


namespace booking\entities\medicine;


use booking\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ReviewMedicine
 * @package booking\entities\medicine
 * @property integer $id
 * @property integer $page_id
 * @property integer $created_at
 * @property string $user_id
 * @property string $text
 * @property User $user
 *
 */
class ReviewMedicine extends ActiveRecord
{

    final public static function create($userId, string $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->text = $text;
        $review->created_at = time();
        return $review;
    }

    public static function tableName()
    {
        return '{{%medicine_review}}';
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}