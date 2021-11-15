<?php


namespace booking\entities\touristic\stay;

use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\touristic\BaseObjectOfTouristic;
use booking\entities\touristic\TouristicContact;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;


/**
 * Class Fun
 * @package booking\entities\touristic\stay
 * @property integer $id
 * @property integer $category_id - Тип (entities)
 * @property string $name - Название
 * @property string $title - H1
 * @property string $slug
 * @property string $description ... на странице категории
 * @property string $content
 *
 * @property integer $main_photo_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property float $rating
 * @property integer $featured_at
 * @property integer $sort
 * ====== GET-Ы ============================================
 * @property Category $category
 * @property Photo $mainPhoto
 * @property ReviewStay[] $reviews
 * @property Photo[] $photos
 * @property string $meta_json
 * @property string $contact_phone [varchar(255)]
 * @property string $contact_url [varchar(255)]
 * @property string $contact_email [varchar(255)]
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 */

class Stay extends BaseObjectOfTouristic
{
    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;
    /** @var $contact TouristicContact */
    public $contact;

    public static function create($category_id, $name, $title, $slug, $description, $content, BookingAddress $address, Meta $meta, TouristicContact $contact): self
    {
        $stay = new static();
        $stay->category_id = $category_id;
        $stay->name = $name;
        $stay->title = empty($title) ? $name : $title;
        $stay->description = $description;
        $stay->content = $content;
        $stay->address = $address;
        $stay->meta = $meta;
        $stay->contact = $contact;

        $stay->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $stay->created_at = time();
        $stay->status = StatusHelper::STATUS_INACTIVE;
        $stay->featured_at = null; //Если дата больше текущей, то вверху. Сортировка по featured_at

        return $stay;
    }

    public function edit($category_id, $name, $title, $slug, $description, $content, BookingAddress $address, Meta $meta, TouristicContact $contact): void
    {
        $this->category_id = $category_id;
        $this->name = $name;
        $this->title = empty($title) ? $name : $title;
        $this->description = $description;
        $this->content = $content;
        $this->address = $address;
        $this->meta = $meta;
        $this->contact = $contact;

        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;

    }

    public static function tableName()
    {
        return '{{%touristic_stay}}';
    }

    /** getXXX ==========> */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['stay_id' => 'id'])->orderBy('sort');
    }


    public function getReviews(): ActiveQuery
    {
        /** Только активные отзывы */
        return $this->hasMany(ReviewStay::class, ['stay_id' => 'id']);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}