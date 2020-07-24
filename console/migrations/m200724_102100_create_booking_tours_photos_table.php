<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_photos}}`.
 */
class m200724_102100_create_booking_tours_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_tours_photos}}', [
            'id' => $this->primaryKey(),
            'tours_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_tours_photos-tours_id}}', '{{%booking_tours_photos}}', 'tours_id');
        $this->addForeignKey('{{%fk-booking_tours_photos-tours_id}}', '{{%booking_tours_photos}}', 'tours_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_photos}}');
    }
}
