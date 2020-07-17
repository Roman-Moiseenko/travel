<?php


namespace booking\entities\user;


use shop\services\WaterMarker;
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
 * @property Fullname $fullname
 * @property string $photo
 */

class Personal extends ActiveRecord
{

    public static function create($phone, $dateborn, UserAddress $address, FullName $fullName): self
    {
        $personal = new static();
        $personal->phone = $phone;
        $personal->dateborn = $dateborn;
        $personal->address = $address;
        $personal->fullname = $fullName;
        return $personal;
    }

    public function edit($phone, $dateborn, UserAddress $address, FullName $fullName)
    {
        $this->phone = $phone;
        $this->dateborn = $dateborn;
        $this->address = $address;
        $this->fullname = $fullName;
    }

    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }

    public static function tableName()
    {
        return '{{%users_personal}}';
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
                ],
            ],
        ];
    }
}