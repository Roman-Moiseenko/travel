<?php


namespace booking\entities\shops;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Photo;
use booking\entities\Meta;
use booking\helpers\BookingHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Shop
 * @package booking\entities\shops
 * @property integer $id
 * @property integer $user_id
 * @property integer $legal_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property integer $main_photo_id
 * @property float $raiting
 * @property integer $status

 ********************************* Внешние связи
 * @property InfoAddress[] $addresses
 * @property Photo $mainPhoto
 * @property Photo[] $photos

 * @property Contact[] $contacts
 * @property ContactAssign[] $contactAssign
 * @property ReviewShop[] $reviews
 *
 *********************************** Скрытые поля
 * @property Meta $meta
 * @property string $meta_json
 * @property string $work_mode_json
 */

class Shop extends ActiveRecord
{
    /** @var Meta $meta */
    public $meta;
    /** @var WorkMode[] $workModes */
    public $workModes = [];


    public function getName(): string
    {
        //TODO
    }

    public function getDescription(): string
    {
        //TODO
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public function isNew(): bool
    {
        if ($this->created_at == null) return false;
        return (time() - $this->created_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

    public static function tableName()
    {
        return '{{%shops}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'reviews',
                    'contactAssign',
                    'addresses',
                ],
            ],

        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
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