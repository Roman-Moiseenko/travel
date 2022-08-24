<?php
declare(strict_types=1);

namespace booking\services;

use booking\entities\CheckClickUser;
use booking\repositories\CheckClickRepository;

class CheckClickService
{
    /**
     * @var CheckClickRepository
     */
    private $clicks;

    public function __construct(CheckClickRepository $clicks)
    {
        $this->clicks = $clicks;
    }

    public function create($created_at, $class_name, $class_id, $type_event)
    {
        $click = CheckClickUser::create($created_at, $class_name, $class_id, $type_event);
        $this->clicks->save($click);
    }
    //TODO ***
}