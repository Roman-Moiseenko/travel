<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_dialog}}`.
 */
class m200908_134714_create_booking_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_dialog}}', [
            'id' => $this->primaryKey(),
            'typeDialog' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'provider_id' => $this->integer(),
            'theme_id' => $this->integer()->notNull(),
            'optional' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()
        ]);
        $this->createIndex('{{%idx-booking_dialog-user_id}}', '{{%booking_dialog}}', 'user_id');
        $this->createIndex('{{%idx-booking_dialog-theme_id}}', '{{%booking_dialog}}', 'theme_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_dialog}}');
    }
}
