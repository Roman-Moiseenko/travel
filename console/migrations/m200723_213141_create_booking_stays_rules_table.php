<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_rules}}`.
 */
class m200723_213141_create_booking_stays_rules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_rules}}', [
            'id' => $this->primaryKey(),
            'stays_id' => $this->integer()->notNull(),
            'beds_on' => $this->boolean(),

        ]);

        $this->createIndex('{{%idx-booking_stays_rules-stays_id}}', '{{%booking_stays_rules}}', 'stays_id');
        $this->addForeignKey('{{%fk-booking_stays_rules-stays_id}}', '{{%booking_stays_rules}}', 'rooms_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_rules}}');
    }
}
