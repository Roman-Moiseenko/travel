<?php


namespace booking\entities\admin;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Contact
 * @package booking\entities\admin\user
 * @property integer $id
 * @property string $photo
 * @property string $name
 * @property integer $type
 * @property string $prefix
 */
class Contact extends ActiveRecord
{
    const NO_LINK = 0;
    const LINK = 1;

    public static function create(string $name, int $type = 0, string $prefix = ''): self
    {
        $contact = new static();
        $contact->name = $name;
        $contact->type = $type;
        $contact->prefix = $prefix;
        return $contact;
    }

    public function edit(string $name, int $type = 0, string $prefix = ''): void
    {
        $this->name = $name;
        $this->type = $type;
        $this->prefix = $prefix;
    }

    public function setPhoto(UploadedFile $file): void
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
                    'list' => ['width' => 20, 'height' => 20],
                ],
            ],
        ];
    }

}