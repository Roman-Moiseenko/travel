<?php


namespace booking\entities\vmuseum;

use booking\entities\admin\Contact;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ContactAssign
 * @property integer $contact_id
 * @property string $value
 * @property string $description
 * @property Contact $contact
 * @property int $vmuseum_id [int]
 */

class ContactAssign extends ActiveRecord
{

    public static function create(int $contact_id, string $value, string $description): self
    {
        $assignment = new static();
        $assignment->contact_id = $contact_id;
        $assignment->value = $value;
        $assignment->description = $description;
        return $assignment;
    }

    public function edit(string $value, string $description): void
    {
        $this->value = $value;
        $this->description = $description;
    }

    public function isFor($id): bool
    {
        return $this->contact_id == $id;
    }

    public static function tableName()
    {
        return '{{%vmuseum_contact_assign}}';
    }

    public function getContact(): ActiveQuery
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id'])->orderBy(['id' =>  SORT_ASC]);
    }
}