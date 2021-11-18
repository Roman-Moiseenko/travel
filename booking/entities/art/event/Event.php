<?php


namespace booking\entities\art\event;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\behaviors\TouristicContactBehavior;
use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\touristic\TouristicContact;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use booking\services\WaterMarker;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Event
 * @package booking\entities\art\event
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $video
 * @property string $photo
 * @property integer $status
 * @property integer $cost
 * ====== GET-Ы ============================================
 * @property Category $category
 * //////////@property ReviewEvent[] $reviews
 * @property string $meta_json
 * @property Category[] $categories
 * @property CategoryAssignment[] $categoriesAssignment
 * @property string $contact_phone [varchar(255)]
 * @property string $contact_url [varchar(255)]
 * @property string $contact_email [varchar(255)]
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 * @mixin ImageUploadBehavior
 */
class Event extends ActiveRecord
{
    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;
    /** @var $contact TouristicContact */
    public $contact;

    public static function create($name, $category_id, $slug, $title, $description, $content, $video, $cost): self
    {
        $event = new static();
        $event->name = $name;
        $event->category_id = $category_id;
        $event->title = $title;
        $event->description = $description;
        $event->content = $content;
        $event->video = $video;
        $event->cost = $cost;

        $event->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $event->created_at = time();
        $event->status = StatusHelper::STATUS_INACTIVE;
        return $event;
    }

    public function edit($name, $category_id, $slug, $title, $description, $content, $video, $cost): void
    {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->video = $video;
        $this->cost = $cost;

        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
    }

    //***** is-ы *************************

    public function isActive(): bool
    {
        return $this->status == StatusHelper::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status == StatusHelper::STATUS_INACTIVE;
    }

    public function isFree(): bool
    {
        return ($this->cost == null || $this->cost == 0);
    }

    //***** SET-ы *************************
    public function setContact(TouristicContact $contact): void
    {
        $this->contact = $contact;
    }

    public function setPhoto(UploadedFile $photo): void
    {
        $this->photo = $photo;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setAddress(BookingAddress $address): void
    {
        $this->address = $address;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Событие уже опубликовано');
        }
        $this->status = StatusHelper::STATUS_ACTIVE;
    }

    public function inactivate(): void
    {
        if ($this->isInactive()) {
            throw new \DomainException('Событие уже снято с публикации');
        }

        $this->status = StatusHelper::STATUS_INACTIVE;
    }

    public static function tableName()
    {
        return '{{%art_event}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'categoriesAssignment',
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/art/event/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/art/event/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/art/event/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/art/event/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'landing_list' => ['width' => 300, 'height' => 400],

                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_list_2x' => ['width' => 456, 'height' => 228],
                    'catalog_list_2_3x' => ['width' => 456, 'height' => 304],
                    'catalog_list_3x' => ['width' => 342, 'height' => 114],
                    'catalog_list_food' => ['width' => 300, 'height' => 200],
                    'catalog_list_mobile' => ['width' => 320, 'height' => 160],
                    'profile' => ['width' => 400, 'height' => 400],
                    'origin' => ['processor' => [new WaterMarker(1024, 512, '@static/files/images/logo-mail.png'), 'process']],
                ],
            ],
            MetaBehavior::class,
            TimestampBehavior::class,
            BookingAddressBehavior::class,
            TouristicContactBehavior::class,
        ];
    }

    //**** Категории дополнительные (assignCategory) **********************************

    public function assignCategory($id): void
    {
        $assigns = $this->categoriesAssignment;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return;
            }
        }
        $assigns[] = CategoryAssignment::create($id);
        $this->categoriesAssignment = $assigns;
    }

    public function revokeType($id): void
    {
        $assigns = $this->categoriesAssignment;
        foreach ($assigns as $i => $assign) {
            if ($assign->isFor($id)) {
                unset($assigns[$i]);
                $this->categoriesAssignment = $assigns;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function clearType(): void
    {
        $this->categoriesAssignment = [];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCategoriesAssignment(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['event_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoriesAssignment');
    }

    public function getLastDate(): string
    {
        //TODO Если дата в Календаре < текущей, то return '';
        return '0-99 ноября';
    }

    public function getLastAddress(): string
    {
        //TODO Если адреса нет в Календаре, берем из Event
        return 'г.Имя_Города, Локация №1';
    }
}