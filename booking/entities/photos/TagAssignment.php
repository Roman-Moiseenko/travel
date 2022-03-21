<?php
declare(strict_types=1);

namespace booking\entities\photos;

use yii\db\ActiveRecord;

/**
 * @property integer $page_id
 * @property integer $tag_id
 */
class TagAssignment extends ActiveRecord
{

    public static function create($tagId): self
    {
        $assignment = new static();
        $assignment->tag_id = $tagId;
        return  $assignment;
    }

    public function isFor($id): bool
    {
        return $this->tag_id == $id;
    }
    public static function tableName()
    {
        return '{{%photos_tag_assignment}}';
    }
}