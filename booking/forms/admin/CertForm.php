<?php


namespace booking\forms\admin;


use booking\entities\admin\Cert;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class CertForm
 * @package booking\forms\admin
 * @property PhotosForm $file
 */
class CertForm extends CompositeForm
{
    public $name;
    public $issue_at;

    public function __construct(Cert $cert = null, $config = [])
    {

        if ($cert != null) {
            $this->name = $cert->name;
            $this->issue_at = $cert->issue_at ? date('d-m-Y', $cert->issue_at) : '';
            $this->file = new PhotosForm();
        } else {
            $this->file = new PhotosForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['issue_at', 'safe'],
            [['name'], 'string'],
            [['name', 'issue_at'], 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['file'];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (empty($this->issue_at)) {
                $this->issue_at = null;
            } else {
                $this->issue_at = strtotime($this->issue_at . '00:00:00');
            }
            return true;
        }
        return false;
    }
}