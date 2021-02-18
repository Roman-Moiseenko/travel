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
        $this->createTable('{{%booking_stay_nearby}}', [
            'id' => $this->primaryKey(),
            'stay_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'distance' => $this->integer(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-booking_stay_nearby-stay_id}}', '{{%booking_stay_nearby}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stay_nearby-stay_id}}', '{{%booking_stay_nearby}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-booking_stay_nearby-category_id}}', '{{%booking_stay_nearby}}', 'category_id');
        $this->addForeignKey('{{%fk-booking_stay_nearby-category_id}}', '{{%booking_stay_nearby}}', 'category_id', '{{%booking_stay_nearby_category}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stay_nearby}}');
    }
}
