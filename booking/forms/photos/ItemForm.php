<?php
declare(strict_types=1);

namespace booking\forms\photos;

use booking\entities\photos\Item;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property PhotosForm $photo
 */
class ItemForm extends CompositeForm
{
    public $name;
    public $description;

    public function __construct(Item $item = null, $config = [])
    {
        if ($item) {
            $this->name = $item->name;
            $this->description = $item->description;
        }
        $this->photo = new PhotosForm();
        parent::__construct($config);

    }

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo'];
    }
}