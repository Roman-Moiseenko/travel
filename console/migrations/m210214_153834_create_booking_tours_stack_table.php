<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_stack}}`.
 */
class m210214_153834_create_booking_tours_stack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_tours_stack}}', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'name' => $this->string(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-booking_tours_stack-legal_id}}', '{{%booking_tours_stack}}', 'legal_id');
        $this->addForeignKey('{{%fk-booking_tours_stack-legal_id}}', '{{%booking_tours_stack}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_stack}}');
    }
}
