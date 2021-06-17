<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_reviews}}`.
 */
class m210616_204214_create_booking_trips_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_trips_reviews}}', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer()->defaultValue(1)
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_trips_reviews-user_id}}', '{{%booking_trips_reviews}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-booking_trips_reviews-trip_id}}',
            '{{%booking_trips_reviews}}',
            'trip_id',
            '{{%booking_trips}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-booking_trips_reviews-trip_id}}', '{{%booking_trips_reviews}}', 'trip_id');
        $this->addForeignKey(
            '{{%fk-booking_trips_reviews-user_id}}',
            '{{%booking_trips_reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_reviews}}');
    }
}
