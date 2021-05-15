<?php


namespace booking\entities\moving;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class CategoryFAQ
 * @package booking\entities\moving
 * @property integer $id
 * @property integer $sort
 * @property string $caption
 * @property string $description
 * @property FAQ[] $faqMessages
 */
class CategoryFAQ extends ActiveRecord
{

    public static function create($caption, $description): self
    {
        $category = new static();
        $category->caption = $caption;
        $category->description = $description;
        return $category;
    }

    public function edit($caption, $description): void
    {
        $this->caption = $caption;
        $this->description = $description;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%moving_faq_category}}';
    }

    public function setSort(int $sort)
    {
        $this->sort = $sort;
    }

    public function getFaqMessages(): ActiveQuery
    {
        return $this->hasMany(FAQ::class, ['category_id' => 'id']);
    }

    public function countFaq()
    {
        $count = count($this->faqMessages);
        switch ($count % 10) {
            case 1: $text = 'сообщение'; break;
            case 2:case 3: case 4: $text = 'сообщения'; break;
            default:
                $text = 'сообщений';
        }
        return $count . ' ' . $text;
    }
}