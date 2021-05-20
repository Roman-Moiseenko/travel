<?php

//TODO Комментарии/отзывы к главной страницы по переезду
// добавляем ч/з каптчу или только для зарегистрированных (??)
// ставим датапровайдер и показываем только 20 комментов или показываем все, сворачиваем (?)
// делаем ответ на коммент?
// отсылаем вопрос модератору?


namespace booking\entities\moving;


use yii\db\ActiveRecord;

/**
 * Class ReviewMoving
 * @package booking\entities\moving
 * @property integer $id
 * @property integer $created_at
 * @property string $username
 * @property string $email
 * @property string $text
 * @property boolean $status
 *
 */
class ReviewMoving extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%moving_review}}';
    }
}