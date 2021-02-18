<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_rules}}`.
 */
class m210218_152841_create_booking_stays_rules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_rules}}', [
            'id' => $this->primaryKey(),
            'stay_id' => $this->integer()->notNull(),
            'beds_json' => 'JSON NOT NULL',
            'children_json' => 'JSON NOT NULL',
            'parking_json' => 'JSON NOT NULL',
            'checkin_json' => 'JSON NOT NULL',
        ]);
        $this->createIndex('{{%idx-booking_stays_rules-stay_id}}', '{{%booking_stays_rules}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_rules-stay_id}}', '{{%booking_stays_rules}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_rules}}');
    }
}
