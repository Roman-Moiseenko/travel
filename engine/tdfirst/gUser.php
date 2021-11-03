<?php


namespace engine\tdfirst;


use yii\db\ActiveRecord;

/**
 * Class Users
 * @package engine\tdfirst
 * @property integer $id
 * @property integer $created_at
 * @property integer $visited_at
 * @property string $user_id
 *
 * //Получаемые с игры данные для сохранения
 * @property string $settings_json
 * @property string $data_json

 */
class gUser extends ActiveRecord
{
    public static function create(string $user_id): self
    {
        $user = new static();
        $user->created_at = time();
        $user->user_id = $user_id;

        $user->settings_json = '{}';
        $user->data_json = '{"last_level":"Zero"}';
        return $user;
    }

    public function visited(): void
    {
        $this->visited_at = time();
    }

    public function setData(string $data_json): void
    {

        $this->data_json = $data_json;
    }

    public function setSettings(string $settings_json): void
    {
        $this->settings_json = $settings_json;
    }

    public static function tableName()
    {
        return '{{%games_tdfirst_users}}';
    }
}