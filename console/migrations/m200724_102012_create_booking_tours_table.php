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
            'slug' => $this->string(),
            'legal_id' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
            'description' => $this->text(),
            'type_id' => $this->integer(),
            'cancellation' => $this->integer(),
            'rating' => $this->decimal(3, 2),
            'main_photo_id' => $this->integer(),
            'adr_address' => $this->string(),
            'adr_latitude' => $this->string(),
            'adr_longitude' => $this->string(),
            'params_duration' => $this->string(),
            'params_begin_address' => $this->string(),
            'params_begin_latitude' => $this->string(),
            'params_begin_longitude' => $this->string(),
            'params_end_address' => $this->string(),
            'params_end_latitude' => $this->string(),
            'params_end_longitude' => $this->string(),
            'params_limit_on' => $this->boolean(),
            'params_limit_min' => $this->integer(),
            'params_limit_max' => $this->integer(),
            'params_private' => $this->boolean(),
            'params_groupMin' => $this->integer(),
            'params_groupMax' => $this->integer(),
            'params_children' => $this->boolean(),
            'cost_adult' => $this->integer(),
            'cost_child' => $this->integer(),
            'cost_preference' => $this->integer(),
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
