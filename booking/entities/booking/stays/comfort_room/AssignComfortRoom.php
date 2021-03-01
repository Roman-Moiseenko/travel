<?php


namespace booking\entities\booking\stays\comfort_room;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class assignComfort
 * @package booking\entities\booking\stays\comfort_room
 * @property integer $stay_id
 * @property integer $comfort_id
 * @property string $file
 * @property ComfortRoom $comfortRoom
 * @mixin ImageUploadBehavior
 */
class AssignComfortRoom extends ActiveRecord
{

    public static function create($comfort_id): self
    {
        $assign = new static();
        $assign->comfort_id = $comfort_id;
        return $assign;
    }

    public function setPhoto(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public static function tableName()
    {
        return '{{%booking_stays_comfort_room_assign}}';
    }

    public function getComfortRoom(): ActiveQuery
    {
        return $this->hasOne(ComfortRoom::class, ['id' => 'comfort_id'])->orderBy(['category_id' => SORT_ASC, 'sort' => SORT_ASC]);
    }

    public function isFor($id)
    {
        return $this->comfort_id == $id;
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/stays/comfort_room/[[attribute_stay_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/stays/comfort_room/[[attribute_stay_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/stays/comfort_room/[[attribute_stay_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/stays/comfort_room/[[attribute_stay_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 240],
 /*                   'list' => ['width' => 150, 'height' => 150],
                    'top_widget_list'=> ['width' => 30, 'height' => 30],
                    'widget_list' => ['width' => 57, 'height' => 57],
                    'cabinet_list' => ['width' => 70, 'height' => 70],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_main' => ['width' => 1200, 'height' => 400],
                    'catalog_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['width' => 1024, 'height' => 768],*/
                ],
            ],
        ];
    }
}