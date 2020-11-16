<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_service_city}}`.
 */
class m201110_113846_create_booking_service_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_service_city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_service_city}}');
    }
}
