<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_type_assign}}`.
 */
class m200725_165212_create_booking_tours_type_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_tours_type_assign}}', [
            'tours_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_tours_type_assign}}', '{{%booking_tours_type_assign}}', ['tours_id', 'type_id']);

        $this->createIndex('{{%idx-booking_tours_type_assign-tours_id}}', '{{%booking_tours_type_assign}}', 'tours_id');
        $this->createIndex('{{%idx-booking_tours_type_assign-type_id}}', '{{%booking_tours_type_assign}}', 'type_id');

        $this->addForeignKey('{{%fk-booking_tours_type_assign-tours_id}}', '{{%booking_tours_type_assign}}', 'tours_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_tours_type_assign-type_id}}', '{{%booking_tours_type_assign}}', 'type_id', '{{%booking_tours_type}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_type_assign}}');
    }
}
