<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement}}`.
 */
class m210623_211438_create_booking_trips_placement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_trips_placement}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'description' => $this->text(),
            'description_en' => $this->text(),
            'main_photo_id' => $this->integer(),

            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_trips_placement-user_id}}', '{{%booking_trips_placement}}', 'user_id');
        $this->addForeignKey(
            '{{%idx-booking_trips_placement-user_id}}',
            '{{%booking_trips_placement}}',
            'user_id',
            '{{%admin_users}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-booking_trips_placement-type_id}}', '{{%booking_trips_placement}}', 'type_id');
        $this->addForeignKey(
            '{{%idx-booking_trips_placement-type_id}}',
            '{{%booking_trips_placement}}',
            'type_id',
            '{{%booking_trips_placement_type}}',
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
        $this->dropTable('{{%booking_trips_placement}}');
    }
}
