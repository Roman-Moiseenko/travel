<?php


namespace booking\entities\moving\agent;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\FullnameBehavior;
use booking\entities\booking\BookingAddress;
use booking\entities\user\FullName;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Agent
 * @package booking\entities\moving\agent
 * @property integer $id
 * @property integer $sort
 * @property string $description
 * @property string $email
 * @property string $phone
 * @property string $photo
 * @property integer $region_id
 * @property integer $type
 *
 * @property string $person_surname [varchar(255)]
 * @property string $person_firstname [varchar(255)]
 * @property string $person_secondname [varchar(255)]
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 * @property Region $region
 *
 * @mixin ImageUploadBehavior
 */

class Agent extends ActiveRecord
{
    const INNER = 1;
    const OUTER = 2;

    const ARRAY_TYPES = [
        self::INNER => 'Представитель в Калининграде',
        self::OUTER => 'Представитель в регионе',
    ];

    /** @var $address BookingAddress */
    public $address;
    /** @var $person FullName */
    public $person;

    public static function create(FullName $person, $email, $phone, $description, $region_id, $type, BookingAddress $address): self
    {
        $agent = new static();
        $agent->person = $person;
        $agent->phone = $phone;
        $agent->email = $email;
        $agent->description = $description;
        $agent->region_id = $region_id;
        $agent->type = $type;
        $agent->address = $address;

        return $agent;
    }

    public function edit(FullName $person, $email, $phone, $description, $region_id, $type, BookingAddress $address): void
    {
        $this->person = $person;
        $this->phone = $phone;
        $this->email = $email;
        $this->description = $description;
        $this->region_id = $region_id;
        $this->type = $type;
        $this->address = $address;
    }

    public function getStringType(): string
    {
        return self::ARRAY_TYPES[$this->type];
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function setPhoto(UploadedFile $file)
    {
        $this->photo = $file;
    }

    public static function tableName()
    {
        return '{{%moving_agents}}';
    }

    public function behaviors(): array
    {
        return [
            FullnameBehavior::class,
            BookingAddressBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/moving/agents/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/moving/agents/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/moving/agents/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/moving/agents/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 320],
                    'cart_list' => ['width' => 160, 'height' => 160],
                    'forum' => ['width' => 140, 'height' => 140],
                    'profile' => ['width' => 400, 'height' => 400],
                ],
            ],
        ];
    }

    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }
}