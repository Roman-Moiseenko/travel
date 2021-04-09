<?php


namespace booking\forms\shops;


use booking\entities\shops\products\Size;
use yii\base\Model;

class SizeForm extends Model
{
    public $width;
    public $height;
    public $depth;


    public function __construct(Size $size = null, $config = [])
    {
        if ($size) {
            $this->width = $size->width;
            $this->height = $size->height;
            $this->depth = $size->depth;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['width', 'height', 'depth'], 'integer'],
            [['width', 'height', 'depth'], 'required', 'message' => 'Обязательное поле'],
        ];
    }
}