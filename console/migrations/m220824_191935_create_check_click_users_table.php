<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%check_click_users}}`.
 */
class m220824_191935_create_check_click_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%check_click_user}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'class_name' => $this->string(),
            'class_id' => $this->integer(),
            'type_event' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%check_click_user}}');
    }
}
