<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_comfort_room}}`.
 */
class m210228_213438_create_booking_stays_comfort_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_comfort_room}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            'photo' => $this->boolean(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_stays_comfort_room-category_id}}', '{{%booking_stays_comfort_room}}', 'category_id');
        $this->addForeignKey('{{%fk-booking_stays_comfort_room-category_id}}', '{{%booking_stays_comfort_room}}', 'category_id',
            '{{%booking_stays_comfort_room_category}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_comfort_room}}');
    }
}
