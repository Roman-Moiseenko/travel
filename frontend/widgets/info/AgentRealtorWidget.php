<?php

namespace frontend\widgets\info;

use booking\helpers\SysHelper;
use yii\base\Widget;

class AgentRealtorWidget extends Widget
{
    public $name = 'Специалист по недвижимости Олег';
    public $phone = '8-950-676-3594';
    public $img = 'https://static.koenigs.ru/images/page/about/oleg.jpg';

    public function run()
    {
        return $this->render('agent_realtor', [
            'name' => $this->name,
            'phone' => $this->phone,
            'img' => $this->img,
            'mobile' => SysHelper::isMobile(),
        ]);
    }
}