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
 * @property string $user_name
 * @property integer $level_open
 * @property string $points
 * @property string $levels_json
 * @property string $resources_json
 * @property string $researches_json
 */
class gUser extends ActiveRecord
{
    public static function create(string $user_id): self
    {
        $user = new static();
        $user->created_at = time();
        $user->user_id = $user_id;
        $user->level_open = 0;
        $user->points = 0;
        $user->levels_json = '{}';
        $user->resources_json = '{}';
        $user->researches_json = '{}';
        return $user;
    }

    public function visited(): void
    {
        $this->visited_at = time();
    }

    public function edit($level_open, $points, $levels_json, $resources_json, $researches_json): void
    {
        $this->level_open = $level_open;
        $this->points = $points;
        $this->levels_json = $levels_json;
        $this->resources_json = $resources_json;
        $this->researches_json = $researches_json;
    }

    public function SetName(string $user_name): void
    {
        $this->user_name = $user_name;
    }

    public static function tableName()
    {
        return '{{%games_tdfirst_users}}';
    }
}