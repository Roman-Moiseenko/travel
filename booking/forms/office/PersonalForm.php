<?php
declare(strict_types=1);

namespace booking\forms\office;

use booking\entities\office\User;
use booking\entities\PersonalInterface;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\manage\FullNameForm;

/**
 *
 * @property PhotosForm $photo
 * @property FullNameForm $fullname
 */
class PersonalForm extends CompositeForm
{
    public $home_page;
    public $description;

    public function __construct(User $personal, $config = [])
    {
        $this->home_page = $personal->home_page;
        $this->description = $personal->description;

        $this->fullname = new FullNameForm($personal->fullname);
        $this->photo = new PhotosForm();

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['home_page', 'description'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo', 'fullname'];
    }
}