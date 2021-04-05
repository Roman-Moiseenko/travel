<?php


namespace booking\entities\shops;

use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\funs\WorkMode;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class AdShop
 * @package booking\entities\shops
 * @property integer $main_photo_id
 * @property InfoAddress[] $addresses
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property Contact[] $contacts
 * @property ContactAssign[] $contactAssign
 * @property string $work_mode_json
 *
 *
 */
class AdShop extends BaseShop
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];

    public function isAd(): bool
    {
        return true;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public static function tableName()
    {
        return '{{%shops_ad}}';
    }

    public function behaviors()
    {
        $result = parent::behaviors();
        $new_behaviors = [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'contactAssign',
                    'addresses',
                ],
            ],

        ];
        return array_merge($result, $new_behaviors);
    }


    //**** Контакты (ContactAssign) **********************************

    public function addContact(int $contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssign;
        $contact = ContactAssign::create($contact_id, $value, $description);
        $contacts[] = $contact;
        $this->contactAssign = $contacts;
    }

    public function updateContact($contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssign;
        foreach ($contacts as &$contact) {
            if ($contact->isFor($contact_id)) {
                $contact->edit($value, $description);
            }
        }
        $this->contactAssign = $contacts;
    }

    public function removeContact($contact_id)
    {
        $contacts = $this->contactAssign;
        foreach ($contacts as $i => $contact) {
            if ($contact->isFor($contact_id)) {
                unset($contacts[$i]);
                $this->contactAssign = $contacts;
                return;
            }
        }
    }

    //****** Внешние связи *****

    public function getContactAssign(): ActiveQuery
    {
        return $this->hasMany(ContactAssign::class, ['food_id' => 'id']);
    }

    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])->via('contactAssign');
    }
}