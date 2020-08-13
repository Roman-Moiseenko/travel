<?php


namespace booking\entities\admin\user;


use booking\entities\booking\BookingAddress;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
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
 * @property string $INN
 * @property string $KPP
 * @property string $OGRN
 * @property string $BIK
 * @property string $account
 * @property string $photo
 * @property string $description
 * @property BookingAddress $address
 * @property integer $created_at
 * @property string $office
 * @property string $noticePhone
 * @property string $noticeEmail
 */
class UserLegal extends ActiveRecord
{
    public $address;

    public static function create($name, $BIK, $account, $INN,
                                  $caption, $description, BookingAddress $address,
                                  $office, $noticePhone, $noticeEmail,
                                  $OGRN = null, $KPP = null): self
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
        return $legal;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function edit($name, $BIK, $account, $INN,
                         $caption, $description, BookingAddress $address,
                         $office, $noticePhone, $noticeEmail,
                         $OGRN = null, $KPP = null): void
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
    }

    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }

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
                ],
            ],
        ];
    }
}