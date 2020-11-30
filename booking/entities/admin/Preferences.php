<?php


namespace booking\entities\admin;


use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Preferences
 * @package booking\entities\admin
 * @property integer $id
 * @property integer $user_id
 * @property string $params_json
 */
class Preferences extends ActiveRecord
{
    public $days_review = 7;
    public $view_cancel = true;

    public static function create($days_review = 7, $view_cancel = true): self
    {
        $preferences = new static();
        $preferences->days_review = $days_review;
        $preferences->view_cancel = $view_cancel;
        return $preferences;
    }

    public function setDaysReview($days): void
    {
        $this->days_review = $days;
    }

    public function setViewCancel($view): void
    {
        $this->view_cancel = $view;
    }

    public static function tableName()
    {
        return '{{%admin_user_preferences}}';
    }

    public function afterFind(): void
    {
        $params = Json::decode($this->getAttribute('params_json'), true);

        $this->days_review = $params['days_review'] ?? 7;
        $this->view_cancel = $params['view_cancel'] ?? true;

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('params_json', Json::encode([
            'days_review' => $this->days_review,
            'view_cancel' => $this->view_cancel,
        ]));

        return parent::beforeSave($insert);
    }
}