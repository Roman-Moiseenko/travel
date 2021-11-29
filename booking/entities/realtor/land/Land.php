<?php


namespace booking\entities\realtor\land;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\realtor\land\Point;
use booking\helpers\SlugHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Land
 * @package booking\entities\land
 * @property integer $id
 * @property string $name
 * @property integer $cost
 * @property string $points_json
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $photo
 * @property string $meta_json [json]
 * @mixin ImageUploadBehavior
 */

class Land extends ActiveRecord
{
    /** @var $points Point[]  */
    public $points = [];
    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;

    public static function create($name, $slug, $cost, $title, $description, $content, Meta $meta, BookingAddress $address): self
    {
        $land = new static();
        $land->name = $name;
        $land->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $land->cost = $cost;

        $land->title = $title;
        $land->description = $description;
        $land->content = $content;

        $land->meta = $meta;
        $land->address = $address;
        return $land;
    }

    public function edit($name, $slug, $cost, $title, $description, $content, Meta $meta, BookingAddress $address): void
    {
        $this->name = $name;
        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $this->cost = $cost;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;

        $this->meta = $meta;
        $this->address = $address;
    }

    public function setPhoto(UploadedFile $photo)
    {
        $this->photo = $photo;
    }

    public function setPoints(array $points): void
    {
        $this->points = $points;
    }

    public static function tableName(): string
    {
        return '{{%land_anonymous}}';
    }

    public function afterFind()
    {
        parent::afterFind();

        $points = json_decode($this->getAttribute('points_json'));
        foreach ($points as $point) {
            $this->points[] = Point::create($point->latitude, $point->longitude);
        }
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('points_json', json_encode($this->points));
        return parent::beforeSave($insert);
    }

    public function addPoint(Point $point): void
    {
        $this->points[] = $point;
    }

    public function clearPoints(): void
    {
        $this->points = [];
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            BookingAddressBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/realtor/land/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/realtor/land/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/realtor/land/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/realtor/land/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'office_view' => ['width' => 300, 'height' => 200],
                    'list_lands' => ['width' => 900, 'height' => 300],
                    'for_map' => ['width' => 160, 'height' => 160],
                    'landing' => ['width' => 1024, 'height' => 512],
                ],
            ],
        ];
    }
}