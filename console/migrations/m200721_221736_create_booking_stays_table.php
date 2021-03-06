<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays}}`.
 */
class m200721_221736_create_booking_stays_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'legal_id'=> $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer(),
            'stars' => $this->integer()->defaultValue(0),
            'rating' => $this->decimal(3, 2),
            'main_photo_id' => $this->integer(),
            'type_id' => $this->integer(),
            'adr_address' => $this->string(),
            'adr_latitude' => $this->string(),
            'adr_longitude' => $this->string(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_stays-type_id}}', '{{%booking_stays}}','type_id');

        $this->addForeignKey('{{%fk-booking_stays-type_id}}', '{{%booking_stays}}', 'type_id', '{{%booking_stays_type}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays-legal_id}}', '{{%booking_stays}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays}}');
    }
}
