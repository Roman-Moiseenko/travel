<?php


namespace booking\entities\booking\stays;


use booking\entities\booking\rooms\Rooms;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Stays
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $name
 * @property integer $status
 * @property integer $stars
 * @property float $rating
 * @property integer $main_photo_id
 * @property StaysType $type
 * @property StaysAddress $address
 * @property Geo $geo
 * @property Photo[] $photos
 * @property Review[] $reviews
 * @property Rooms[] $rooms
 *
 */
class Stays extends ActiveRecord
{
    const STATUS_LOCK = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;


    public static function create($name, StaysType $type, StaysAddress $address, Geo $geo, $stars = 0): self
    {
        $stays = new static();
        $stays->created_at = time();
        $stays->name = $name;
        $stays->status = Stays::STATUS_INACTIVE;
       // $stays->rating = null;
        $stays->type = $type;
        $stays->address = $address;
        $stays->geo = $geo;
        $stays->stars = $stars;
        return $stays;
    }

    public function edit()
    {

    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Жилище уже активировано');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function inactivate(): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Жилище уже деактивировано');
        }
        $this->status = self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public static function tableName()
    {
        return '{{%booking_stays}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                   // 'categoryAssignments',
                   // 'values',
                    'photos',
                   // 'tagAssignments',
                  //  'relatedAssignments',
                    'reviews'
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterFind(): void
    {

        $this->address = new StaysAddress(
            $this->getAttribute('town'),
            $this->getAttribute('street'),
            $this->getAttribute('house'),
        );

        $this->geo = new Geo(
            $this->getAttribute('latitude'),
            $this->getAttribute('longitude')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('town', $this->address->town);
        $this->setAttribute('street', $this->address->street);
        $this->setAttribute('house', $this->address->house);

        $this->setAttribute('latitude', $this->geo->latitude);
        $this->setAttribute('longitude', $this->geo->longitude);

        return parent::beforeSave($insert);
    }

    /** Review  ==========>*/

    public function addReview($userId, $vote, $text): Review
    {
        $reviews = $this->reviews;
        $review = Review::create($userId, $vote, $text);
        $reviews[] = $review;
        $this->updateReviews($reviews);
        return $review;
    }

    public function editReview($id, $vote, $text): void
    {

        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            if ($review->isIdEqualTo($id)) {
                $review->edit($vote, $text);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }

    public function removeReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }

    private function updateReviews(array $reviews): void
    {
        $total = 0;
        /* @var Review $review */
        foreach ($reviews as $review) {
                $total += $review->getRating();
        }
        $this->reviews = $reviews;
        $this->rating = $total / count($reviews);
    }

    /** <==========  Reviews  */

    /** Photo ==========> */

    public function addPhotoClass(Photo $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
        $this->updatePhotos($photos);
    }

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    /** <========== Photo */

}