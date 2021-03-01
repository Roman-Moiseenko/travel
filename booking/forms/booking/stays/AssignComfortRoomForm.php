<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\comfort\AssignComfort;
use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\AssignComfortRoom;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\helpers\scr;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class AssignComfortRoomForm
 * @package booking\forms\booking\stays
 */
class AssignComfortRoomForm extends Model
{
    public $comfort_id;
    public $_comfort;
    public $_assignComfort;
    public $file;
    public $_index;
    public $checked;

    public function __construct(ComfortRoom $comfort, $_index, AssignComfortRoom $assignComfort = null, $config = [])
    {
        $this->_comfort = $comfort;
        $this->_index = $_index;
        $this->comfort_id = $comfort->id;
        if ($assignComfort) {
            $this->checked = true;
            $this->_assignComfort = $assignComfort;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['comfort_id'], 'integer'],
            ['file', 'image'],
            ['checked', 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'value' => $this->_comfort->name,
        ];
    }

    public function getId(): int
    {
        return $this->_comfort->id;
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, '[' . $this->_index . ']file');
            return true;
        }
        return false;
    }
}