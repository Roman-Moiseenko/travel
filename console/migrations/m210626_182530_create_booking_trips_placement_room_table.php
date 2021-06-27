<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_room}}`.
 */
class m210626_182530_create_booking_trips_placement_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_trips_placement_room}}', [
            'id' => $this->primaryKey(),
            'placement_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'name_en' => $this->string(),
            'main_photo_id' => $this->integer(),
            'meals_id' => $this->integer(),
            'quantity' => $this->integer()->defaultValue(1),
            'cost' => $this->integer()->notNull(),
            'capacity' => $this->integer()->notNull(),
            'shared' => $this->boolean()->defaultValue(false),
        ], $tableOptions);

        $this->createIndex('{{%booking_trips_placement_room}}', '{{%booking_trips_placement_room}}', 'placement_id');
        $this->addForeignKey(
            '{{%booking_trips_placement_room}}',
            '{{%booking_trips_placement_room}}',
            'placement_id',
            '{{%booking_trips_placement}}',
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
        $this->dropTable('{{%booking_trips_placement_room}}');
    }
}
