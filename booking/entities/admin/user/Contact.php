<?php


namespace booking\entities\admin\user;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Contact
 * @package booking\entities\admin\user
 * @property integer $id
 * @property string $photo
 * @property string $name
 */
class Contact extends ActiveRecord
{

    public static function create($name): self
    {
        $contact = new static();
        $contact->name = $name;
        return $contact;
    }

    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }

    public static function tableName()
    {
        return '{{%admin_user_legal_contact}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/files/images/contacts/[[id]].[[extension]]',
                'fileUrl' => '@static/files/images/contacts/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/files_contacts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/files_contacts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'icon' => ['width' => 32, 'height' => 32],
                    'list' => ['width' => 60, 'height' => 60],
                ],
            ],
        ];
    }
}