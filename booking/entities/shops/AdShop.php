<?php


namespace booking\entities\shops;

use booking\entities\admin\Contact;
use booking\entities\booking\funs\WorkMode;

/**
 * Class AdShop
 * @package booking\entities\shops
 * @property integer $main_photo_id
 * @property InfoAddress[] $addresses
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property Contact[] $contacts
 * @property ContactAssign[] $contactAssign
 * @property string $work_mode_json
 *
 *
 */
class AdShop extends Shop
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];
}