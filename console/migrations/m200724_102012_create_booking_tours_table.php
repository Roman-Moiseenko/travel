<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours}}`.
 */
class m200724_102012_create_booking_tours_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'legal_id' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
            'discription' => $this->string(),
            'type_id' => $this->integer(),

            'adr_town' => $this->string(),
            'adr_street' => $this->string(),
            'adr_house' => $this->string(),
            'adr_latitude' => $this->string(),
            'adr_longitude' => $this->string(),
            'params_'

        ], $tableOptions);
        $this->createIndex('{{%idx-booking_tours-type_id}}', '{{%booking_tours}}','type_id');
        $this->addForeignKey('{{%fk-booking_tours-type_id}}', '{{%booking_tours}}', 'type_id', '{{%booking_tours_type}}', 'id', 'SET NULL', 'RESTRICT');

        $this->addForeignKey('{{%fk-booking_tours-legal_id}}', '{{%booking_tours}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours}}');
    }
}
