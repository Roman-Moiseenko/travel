<?php


namespace booking\entities\user;

use booking\entities\booking\funs\Fun;
use booking\entities\booking\WishlistItemInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $user_id
 * @property integer $fun_id
 * @property Fun $fun
 */
class WishlistFun extends ActiveRecord implements WishlistItemInterface
{

    public static function create($fun_id): self
    {
        $wishlist = new static();
        $wishlist->fun_id = $fun_id;
        return $wishlist;
    }

    public function isFor($fun_id): bool
    {
        return $this->fun_id == $fun_id;
    }

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }

    public static function tableName()
    {
        return '{{%user_wishlist_funs}}';
    }

    /** ===> WishlistItemInterface */

    public function getName(): string
    {
        return $this->fun->getName();
    }

    public function getLink(): string
    {
        return Url::to(['fun/view', 'id' => $this->fun_id]);
    }

    public function getPhoto(): string
    {
        return $this->fun->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_FUNS;
    }

    public function getId(): string
    {
        return $this->fun_id;
    }

    public function getRemoveLink(): string
    {
        return Url::to(['cabinet/wishlist/del-fun', 'id' => $this->fun_id]);
    }
}