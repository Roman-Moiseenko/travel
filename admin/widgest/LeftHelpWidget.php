<?php


namespace admin\widgest;


use booking\entities\admin\Help;
use booking\helpers\scr;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class LeftHelpWidget extends Widget
{
    public $page_id = 0;

    public function parentsList()
    {
        return ArrayHelper::map(Help::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(), 'id', function (array $page) {
            $text = ($page['depth'] > 1 ? str_repeat('&#160;&#160;&#160;', $page['depth'] - 1) . ' ' : '') . $page['title'];
            return '<div class="link_admin_help ' . ($this->page_id == $page['id'] ? 'active' : '') . '">' .
                Html::a($text, Url::to(['/help/view', 'id' => $page['id']])) .
                '</div>';
        });
    }

    public function run()
    {
        return $this->render('left_help', [
            'list' => $this->parentsList()
        ]);
    }

}