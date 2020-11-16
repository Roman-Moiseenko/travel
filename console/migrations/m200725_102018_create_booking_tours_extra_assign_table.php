<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_extra_assign}}`.
 */
class m200725_102018_create_booking_tours_extra_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours_extra_assign}}', [
            'tours_id' => $this->integer()->notNull(),
            'extra_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_tours_extra_assign}}', '{{%booking_tours_extra_assign}}', ['tours_id', 'extra_id']);

        $this->createIndex('{{%idx-booking_tours_extra_assign-tours_id}}', '{{%booking_tours_extra_assign}}', 'tours_id');
        $this->createIndex('{{%idx-booking_tours_extra_assign-extra_id}}', '{{%booking_tours_extra_assign}}', 'extra_id');

        $this->addForeignKey('{{%fk-booking_tours_extra_assign-tours_id}}', '{{%booking_tours_extra_assign}}', 'tours_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_tours_extra_assign-extra_id}}', '{{%booking_tours_extra_assign}}', 'extra_id', '{{%booking_tours_extra}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_extra_assign}}');
    }
}
