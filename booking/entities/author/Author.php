<?php
declare(strict_types=1);

namespace booking\entities\author;

use booking\entities\user\FullName;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $born_at
 * @property string $photo

 */

class Author extends ActiveRecord
{
    /** @var $fullname FullName */
    public $fullName;

    public static function create($born_at): self
    {
        $author = new static();

        return $author;
    }

    public static function tableName(): string
    {
        return '{%article_author}';
    }

}