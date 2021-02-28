<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_comfort_room_category}}`.
 */
class m210228_213203_create_booking_stays_comfort_room_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_comfort_room_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_comfort_room_category}}');
    }
}
