<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_photos}}`.
 */
class m200721_221829_create_booking_stays_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_stays_photos}}', [
            'id' => $this->primaryKey(),
            'stays_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_stays_photos-stays_id}}', '{{%booking_stays_photos}}', 'stays_id');
        $this->addForeignKey('{{%fk-booking_stays_photos-stays_id}}', '{{%booking_stays_photos}}', 'stays_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_photos}}');
    }
}
