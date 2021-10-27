<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%games_tdfirst_users}}`.
 */
class m211027_104211_create_games_tdfirst_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%games_tdfirst_users}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'visited_at' => $this->integer(),
            'user_id' => $this->string(),
            'user_name' => $this->string(),
            'level_open' => $this->integer(),
            'points' => $this->integer(),
            'levels_json' => 'JSON NOT NULL',
            'resources_json' => 'JSON NOT NULL',
            'researches_json' => 'JSON NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%games_tdfirst_users}}');
    }
}
