<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stay_nearby}}`.
 */
class m210218_205050_create_booking_stay_nearby_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_nearby}}', [
            'id' => $this->primaryKey(),
            'stay_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'distance' => $this->integer(),
            'category_id' => $this->integer()->notNull(),
            //'unit' => $this->string(2),
        ]);

        $this->createIndex('{{%idx-booking_stays_nearby-stay_id}}', '{{%booking_stays_nearby}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_nearby-stay_id}}', '{{%booking_stays_nearby}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE');

        $this->createIndex('{{%idx-booking_stays_nearby-category_id}}', '{{%booking_stays_nearby}}', 'category_id');
        $this->addForeignKey('{{%fk-booking_stays_nearby-category_id}}', '{{%booking_stays_nearby}}', 'category_id', '{{%booking_stay_nearby_category}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stay_nearby}}');
    }
}
