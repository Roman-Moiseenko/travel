<?php


namespace booking\entities\admin\user;


use yii\db\ActiveRecord;

/**
 * Class ContactAssignment
 * @package booking\entities\admin\user
 * @property integer $id
 * @property integer $legal_id
 * @property integer $contact_id
 * @property string $value
 * @property string $description
 * @property string $link
 */

class ContactAssignment extends ActiveRecord
{

    public static function create($contact_id, $value, $description, $link): self
    {
        $assignment = new static();
        $assignment->contact_id = $contact_id;
        $assignment->value = $value;
        $assignment->description = $description;
        $assignment->link = $link;
        return $assignment;
    }

    public function edit($value, $description, $link)
    {
        $this->value = $value;
        $this->description = $description;
        $this->link = $link;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%admin_user_legal_contact_assignment}}';
    }
}