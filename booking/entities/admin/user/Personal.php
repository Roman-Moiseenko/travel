<?php


namespace booking\entities\admin\user;


//use shop\services\WaterMarker;
use booking\entities\PersonalInterface;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Personal
 * @package booking\entities\admin\user
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property integer $dateborn
 * @property UserAddress $address
 * @property Fullname $fullname
 * @property string $photo
 * @property string $position
 * @mixin ImageUploadBehavior
 */
class Personal extends ActiveRecord implements PersonalInterface
{

    public $fullname;
    public $address;

    public static function create($phone, $dateborn, UserAddress $address, FullName $fullName, $position): self
    {
        $personal = new static();
        $personal->phone = $phone;
        $personal->dateborn = $dateborn;
        $personal->address = $address;
        $personal->fullname = $fullName;
        $personal->position = $position;
        return $personal;
    }

    public function edit($phone, $dateborn, UserAddress $address, FullName $fullName, $position)
    {
        $this->phone = $phone;
        $this->dateborn = $dateborn;
        $this->address = $address;
        $this->fullname = $fullName;
        $this->position = $position;
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
        return '{{%admin_user_personal}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/admin_users/[[attribute_user_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/admin_users/[[attribute_user_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/admin_users/[[attribute_user_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/admin_users/[[attribute_user_id]]/[[profile]]_[[id]].[[extension]]',
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