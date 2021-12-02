<?php

namespace frontend\widgets\info;

use booking\helpers\SysHelper;
use yii\base\Widget;

class AgentRealtorWidget extends Widget
{
    public $landowner_id;

    public function run()
    {
        $mobile = SysHelper::isMobile();
        $name = 'Специалист по недвижимости Олег';
        $phone = '8-950-676-3594';
        $img = 'https://static.koenigs.ru/images/page/about/oleg.jpg';
        return $this->render('agent_realtor', [
            'name' => $name,
            'phone' => $phone,
            'img' => $img,
            'mobile' => $mobile,
        ]);
    }
}