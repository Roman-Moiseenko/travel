<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_services}}`.
 */
class m210227_185246_create_booking_stays_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_services}}', [
            'id' => $this->primaryKey(),
            'stay_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'value' => $this->integer()->notNull(),
            'payment' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_stays_services-stay_id}}', '{{%booking_stays_services}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_services-stay_id}}', '{{%booking_stays_services}}', 'stay_id', 'booking_stays', 'id', 'CASCADE' );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_services}}');
    }
}
