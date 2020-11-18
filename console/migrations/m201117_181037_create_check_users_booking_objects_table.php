<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%check_users_booking_objects}}`.
 */
class m201117_181037_create_check_users_booking_objects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%check_users_booking_objects}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'object_type' => $this->integer()->notNull(),
            'object_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-check_users_booking_objects-user_id}}', '{{%check_users_booking_objects}}', 'user_id');
        $this->addForeignKey('{{%fk-check_users_booking_objects-user_id}}', '{{%check_users_booking_objects}}', 'user_id', '{{%check_users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%check_users_booking_objects}}');
    }
}
