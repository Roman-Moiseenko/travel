<?php


namespace booking\entities\user;


//use shop\services\WaterMarker;
use booking\entities\PersonalInterface;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Personal
 * @package booking\entities\user
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property integer $dateborn
 * @property UserAddress $address
 * @property string $photo
 * @property bool $agreement
 * @property string $surname [varchar(255)]
 * @property string $firstname [varchar(255)]
 * @property string $secondname [varchar(255)]
 * @property string $country [varchar(2)]
 * @property string $index [varchar(255)]
 * @property string $town [varchar(255)]
 * @mixin ImageUploadBehavior
 */

class Personal extends ActiveRecord implements PersonalInterface
{
    /** @var $fullname FullName */
    public $fullname;
    public $address;

    public static function create($phone, $dateborn, UserAddress $address, FullName $fullName, $agreement = false): self
    {
        $personal = new static();
        $personal->phone = $phone;
        $personal->dateborn = $dateborn;
        $personal->address = $address;
        $personal->fullname = $fullName;
        $personal->agreement = $agreement;
        return $personal;
    }

    public function edit($phone, $dateborn, UserAddress $address, FullName $fullName, $agreement)
    {
        $this->phone = $phone;
        $this->dateborn = $dateborn;
        $this->address = $address;
        $this->fullname = $fullName;
        $this->agreement = $agreement;
    }

    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }

    public function afterFind(): void
    {

        $this->fullname = new FullName(
            $this->getAttribute('surname'),
            $this->getAttribute('firstname'),
            $this->getAttribute('secondname'),
        );

        $this->address = new UserAddress(
            $this->getAttribute('country'),
            $this->getAttribute('town'),
            $this->getAttribute('address'),
            $this->getAttribute('index'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('surname', $this->fullname->surname);
        $this->setAttribute('firstname', $this->fullname->firstname);
        $this->setAttribute('secondname', $this->fullname->secondname);

        $this->setAttribute('country', $this->address->country);
        $this->setAttribute('index', $this->address->index);
        $this->setAttribute('town', $this->address->town);
        $this->setAttribute('address', $this->address->address);

        return parent::beforeSave($insert);
    }

    public static function tableName()
    {
        return '{{%user_personal}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/users/[[attribute_user_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/users/[[attribute_user_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/users/[[attribute_user_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/users/[[attribute_user_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
                    'cart_list' => ['width' => 150, 'height' => 150],
                    'profile' => ['width' => 400, 'height' => 400],
                    'forum' => ['width' => 140, 'height' => 140],
                    'forum_mobile' => ['width' => 60, 'height' => 60],
                ],
            ],
        ];
    }
}