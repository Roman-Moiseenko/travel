<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%games_tdfirst_users}}`.
 */
class m211102_135514_create_games_tdfirst_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%games_tdfirst_users}}');

        $this->createTable('{{%games_tdfirst_users}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'visited_at' => $this->integer(),
            'user_id' => $this->string(),
            'data_json' => 'JSON NOT NULL',
            'settings_json' => 'JSON NOT NULL',
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
