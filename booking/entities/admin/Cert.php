<?php


namespace booking\entities\admin;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Cert
 * @package booking\entities\admin
 * @property integer $id
 * @property integer $legal_id
 * @property string $file
 * @property string $name
 * @property integer $issue_at
 */
class Cert extends ActiveRecord
{

    public static function create(UploadedFile $file, string $name, $issue_at): self
    {
        $cert = new static();
        $cert->file = $file;
        $cert->name = $name;
        $cert->issue_at = $issue_at;
        return $cert;
    }

    public function edit(string $name, $issue_at): void
    {
        $this->name = $name;
        $this->issue_at = $issue_at;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function isIdEqualTo(int $id): bool
    {
        return $this->id == $id;
    }
    public static function tableName()
    {
        return '{{%admin_user_legal_certs}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/certs/[[attribute_legal_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/certs/[[attribute_legal_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/certs/[[attribute_legal_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/certs/[[attribute_legal_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 320],
                    'cart_list' => ['width' => 160, 'height' => 160],
                    'profile' => ['width' => 400, 'height' => 400],
                    'profile_mobile' => ['width' => 400, 'height' => 200],
                    'catalog_additional' => ['width' => 66, 'height' => 66],
                ],
            ],
        ];
    }
}