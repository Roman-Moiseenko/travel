<?php


namespace booking\entities\admin;


use booking\entities\admin\Contact;
use booking\entities\admin\ContactAssignment;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\cars\Car;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
use booking\helpers\scr;
use booking\helpers\SlugHelper;
use booking\helpers\SysHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class UserLegal
 * @package booking\entities\admin\user
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $caption
 * @property string $caption_en
 * @property string $INN
 * @property string $KPP
 * @property string $OGRN
 * @property string $BIK
 * @property string $account
 * @property string $photo
 * @property string $description
 * @property string $description_en
 * @property BookingAddress $address
 * @property integer $created_at
 * @property string $office
 * @property string $noticePhone
 * @property string $noticeEmail
 * @property ContactAssignment[] $contactAssignment
 * @property Contact[] $contacts
 * @property User $user
 * @property Tour[] $tours
 * @property Stay[] $stays
 * @property Car[] $cars
 * @property Cert[] $certs
 * @property string $adr_address [varchar(255)]
 * @property string $adr_latitude [varchar(255)]
 * @property string $adr_longitude [varchar(255)]
 */
class Legal extends ActiveRecord
{
    public $address;

    public static function create($name, $BIK, $account, $INN,
                                  $caption, $description, BookingAddress $address,
                                  $office, $noticePhone, $noticeEmail,
                                  $OGRN = null, $KPP = null,
                                  $caption_en = null, $description_en = null): self
    {
        $legal = new static();
        $legal->name = $name;
        $legal->BIK = $BIK;
        $legal->account = $account;
        $legal->INN = $INN;
        $legal->OGRN = $OGRN;
        $legal->KPP = $KPP;
        $legal->caption = $caption;
        $legal->description = $description;
        $legal->address = $address;
        $legal->office = $office;
        $legal->noticePhone = $noticePhone;
        $legal->noticeEmail = $noticeEmail;
        $legal->created_at = time();

        $legal->caption_en = $caption_en;
        $legal->description_en = $description_en;
        return $legal;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function edit($name, $BIK, $account, $INN,
                         $caption, $description, BookingAddress $address,
                         $office, $noticePhone, $noticeEmail,
                         $OGRN = null, $KPP = null,
                         $caption_en = null, $description_en = null
    ): void
    {
        $this->name = $name;
        $this->BIK = $BIK;
        $this->account = $account;
        $this->INN = $INN;
        $this->OGRN = $OGRN;
        $this->KPP = $KPP;
        $this->caption = $caption;
        $this->description = $description;
        $this->address = $address;
        $this->office = $office;
        $this->noticePhone = $noticePhone;
        $this->noticeEmail = $noticeEmail;

        $this->caption_en = $caption_en;
        $this->description_en = $description_en;
    }

    public function setPhoto(UploadedFile $file): void
    {
        $this->photo = $file;
    }


    /** Cert ==========> */

    public function addCert(UploadedFile $file, string $name, $issue_at): void
    {
        $certs = $this->certs;
        $certs[] = Cert::create($file, $name, $issue_at);
        SysHelper::orientation($file->tempName);
        $this->certs = $certs;
    }

    public function updateCert($cert_id, $file, $name, $issue_at): void
    {
        $certs = $this->certs;
        foreach ($certs as &$cert) {
            if ($cert->isIdEqualTo($cert_id)) {
                if ($file->files != null) {
                    $cert->setFile($file->files[0]);
                    SysHelper::orientation($file->files[0]->tempName);
                }
                $cert->edit($name, $issue_at);
            }
        }
        $this->certs = $certs;
    }

    public function removeCert($id): void
    {
        $certs = $this->certs;
        foreach ($certs as $i => $cert) {
            if ($cert->isIdEqualTo($id)) {
                unset($certs[$i]);
                $this->certs = $certs;
                return;
            }
        }
        throw new \DomainException('Документ не найден.');
    }

    public function removeCerts(): void
    {
        $this->certs = [];
    }


    /** <========== Cert */

    public static function tableName()
    {
        return '{{%admin_user_legals}}';
    }

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_address'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('adr_address', $this->address->address);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);
        return parent::beforeSave($insert);
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/admin_users/[[attribute_user_id]]/legals/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/admin_users/[[attribute_user_id]]/legals/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/admin_users/[[attribute_user_id]]/legals/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/admin_users/[[attribute_user_id]]/legals/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 320],
                    'cart_list' => ['width' => 160, 'height' => 160],
                    'profile' => ['width' => 400, 'height' => 400],
                    'profile_new' => ['width' => 300, 'height' => 300],
                    'profile_mobile' => ['width' => 400, 'height' => 200],
                ],
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['contactAssignment','certs'],
            ],
        ];
    }

    public function addContact(int $contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssignment;
        $contact = ContactAssignment::create($contact_id, $value, $description);
        $contacts[] = $contact;
        $this->contactAssignment = $contacts;
    }

    public function updateContact($contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssignment;
        foreach ($contacts as &$contact) {
            if ($contact->isFor($contact_id)) {
                $contact->edit($value, $description);
            }
        }
        $this->contactAssignment = $contacts;
    }

    public function removeContact($contact_id)
    {
        $contacts = $this->contactAssignment;
        foreach ($contacts as $i => $contact) {
            if ($contact->isFor($contact_id)) {
                unset($contacts[$i]);
                $this->contactAssignment = $contacts;
                return;
            }
        }
    }

    //getXXX

    public function getContactAssignment(): ActiveQuery
    {
        return $this->hasMany(ContactAssignment::class, ['legal_id' => 'id'])->orderBy(['contact_id' => SORT_ASC]);
    }

    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])->via('contactAssignment');
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTours(): ActiveQuery
    {
        return $this->hasMany(Tour::class, ['legal_id' => 'id']);
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasMany(Stay::class, ['legal_id' => 'id']);
    }

    public function getCars(): ActiveQuery
    {
        return $this->hasMany(Car::class, ['legal_id' => 'id']);
    }

    public function getCerts(): ActiveQuery
    {
        return $this->hasMany(Cert::class, ['legal_id' => 'id'])->orderBy(['issue_at' => SORT_ASC]);
    }

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT) ? $this->name : SlugHelper::slug($this->name, [
            'separator' => ' ',
            'lowercase' => false,
        ]);
    }

    public function getCaption()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->caption_en)) ? $this->caption : $this->caption_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

}