<?php


namespace admin\widgest;


use booking\entities\message\Dialog;
use booking\repositories\booking\BookingRepository;
use booking\repositories\DialogRepository;
use booking\services\DialogService;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class MessageTopBarWidget extends Widget
{
    /**
     * @var DialogRepository
     */
    private $dialogs;

    public function __construct(DialogRepository $dialogs, $config = [])
    {
        parent::__construct($config);
        $this->dialogs = $dialogs;
    }

    public function run()
    {
        if (\Yii::$app->user->isGuest) return '';
        $dialogs = $this->dialogs->getByAdmin(\Yii::$app->user->id);

        $array_map = ArrayHelper::map($dialogs, 'id', function (Dialog $dialog) {
            return ['theme' => $dialog->theme->caption,'count' => $dialog->countNewConversation()];
        });
        $array_filter = array_filter($array_map, function ($var) {
            if ($var['count'] == 0) return false;
            return true;
        });
        return $this->render('message_top_bar', [
            'dialogs' => $array_filter,
        ]);
    }
}