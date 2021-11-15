<?php

namespace booking\entities\touristic\stay;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property integer $fun_id
 * @property Stay $stay
 * @property int $status
 * @property User $user
 */
class ReviewStay extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%touristic_stay_reviews}}';
    }

    public function getStay(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'fun_id']);
    }

    public function getLinks(): array
    {
        return [
           // 'admin' => Url::to(['fun/review/index', 'id' => $this->fun_id]),
            'frontend' => Url::to(['stay/view', 'id' => $this->fun_id]),
            'office' => Url::to(['/touristic/stay/view-fun', 'id' => $this->fun_id]),
            'update' => Url::to(['cabinet/review/update-stay', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-stay', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_FUNS;
    }

    public function getName(): string
    {
        return $this->fun->name();
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        //$id = $this->fun->user_id;
        throw new \DomainException('Ошибка вызова');
    }

    public function getLegal(): Legal
    {
        throw new \DomainException('Ошибка вызова');
    }

}