<?php


namespace booking\forms\realtor\land;


use booking\entities\booking\BookingAddress;
use booking\entities\realtor\land\Land;
use booking\entities\realtor\land\Point;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\forms\realtor\land\PointForm;
use yii\base\Model;

/**
 * Class LandForm
 * @package booking\forms\land
 * @property BookingAddress $address
 * @property MetaForm $meta
 * @property PhotosForm $photo
 */
class LandForm extends CompositeForm
{
    public $name;
    public $slug;
    public $cost;
    public $title;
    public $description;
    public $content;

    public function __construct(Land $land = null, $config = [])
    {

        if ($land) {
            $this->name = $land->name;
            $this->slug = $land->slug;
            $this->cost = $land->cost;
            $this->title = $land->title;
            $this->description = $land->description;
            $this->content = $land->content;

            $this->meta = new MetaForm($land->meta);
            $this->address = new BookingAddressForm($land->address);
        } else {
            $this->meta = new MetaForm();
            $this->address = new BookingAddressForm();
        }
        $this->photo = new PhotosForm();

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name','title'], 'required'],
            [['name', 'slug', 'title', 'description', 'content'], 'string'],
            [['cost'], 'integer'],

        ];
    }

    protected function internalForms(): array
    {
        return ['meta', 'address', 'photo'];
    }
/*
    public function beforeValidate(): bool
    {
        $this->points = array_filter(
            array_map(function (PointForm $point) {
                if (empty($point->latitude) || empty($point->longitude)) return false;
                return $point;
            }, $this->points)
        );
        return parent::beforeValidate();
    }*/
}