<?php


namespace booking\entities\user;


use booking\entities\booking\tours\Tour;
use booking\entities\booking\WishlistItemInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $user_id
 * @property integer $tour_id
 * @property Tour $tour
 */
class WishlistTour extends ActiveRecord implements WishlistItemInterface
{

    public static function create($tour_id): self
    {
        $wishlist = new static();
        $wishlist->tour_id = $tour_id;
        return $wishlist;
    }


    public function isFor($tour_id): bool
    {
        return $this->tour_id == $tour_id;
    }

    public function getTour(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'tour_id']);
    }

    public static function tableName()
    {
        return '{{%user_wishlist_tours}}';
    }

    /** ===> WishlistItemInterface */

    public function getName(): string
    {
        return $this->tour->getName();
    }

    public function getLink(): string
    {
        return Url::to(['tour/view', 'id' => $this->tour_id]);
    }

    public function getPhoto(): string
    {
        return $this->tour->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_TOUR;
    }

    public function getId(): int
    {
        return $this->tour_id;
    }

    public function getRemoveLink(): string
    {
        return Url::to(['cabinet/wishlist/del-tour', 'id' => $this->tour_id]);
    }
}