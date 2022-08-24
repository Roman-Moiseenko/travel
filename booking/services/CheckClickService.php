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

    public function create(array $params)
    {
        try {
            $click = CheckClickUser::create($params['class_name'], $params['class_id'], $params['type_event']);
            $this->clicks->save($click);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return 'not_error';
    }
    //TODO ***
}