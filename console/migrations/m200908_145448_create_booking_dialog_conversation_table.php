<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_dialog_conversation}}`.
 */
class m200908_145448_create_booking_dialog_conversation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_dialog_conversation}}', [
            'id' => $this->primaryKey(),
            'dialog_id' => $this->integer()->notNull(),
            'text' => $this->text(),
            'author' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-booking_dialog_conversation-dialog_id}}', '{{%booking_dialog_conversation}}', 'dialog_id');
        $this->addForeignKey('{{%fk-booking_dialog_conversation-dialog_id}}', '{{%booking_dialog_conversation}}', 'dialog_id',
            '{{%booking_dialog}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_dialog_conversation}}');
    }
}
