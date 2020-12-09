<?php


namespace booking\entities\booking\funs;

use booking\entities\booking\AgeLimit;

class FunParams
{
    public $ageLimit;
    public $annotation;
    public $workMode = [];

    public function __construct(AgeLimit $ageLimit, string $annotation = '', array $workMode = [])
    {
        $this->annotation = $annotation;
        $this->ageLimit = $ageLimit;
        $this->workMode = $workMode;
    }
}