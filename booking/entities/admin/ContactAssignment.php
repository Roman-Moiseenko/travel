<?php


namespace booking\entities\admin;


use booking\entities\admin\Contact;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ContactAssignment
 * @package booking\entities\admin\user
 * @property integer $id
 * @property integer $legal_id
 * @property integer $contact_id
 * @property string $value
 * @property string $description
 */

class ContactAssignment extends ActiveRecord
{

    public static function create($contact_id, $value, $description): self
    {
        $assignment = new static();
        $assignment->contact_id = $contact_id;
        $assignment->value = $value;
        $assignment->description = $description;
        return $assignment;
    }

    public function edit($value, $description)
    {
        $this->value = $value;
        $this->description = $description;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%admin_user_legal_contact_assignment}}';
    }

    public function getContact(): ActiveQuery
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id'])->orderBy(['id' =>  SORT_ASC]);
    }
}