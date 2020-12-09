<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_extra_assign}}`.
 */
class m201201_091044_create_booking_funs_extra_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_extra_assign}}', [
            'fun_id' => $this->integer()->notNull(),
            'extra_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_funs_extra_assign}}', '{{%booking_funs_extra_assign}}', ['fun_id', 'extra_id']);

        $this->createIndex('{{%idx-booking_funs_extra_assign-fun_id}}', '{{%booking_funs_extra_assign}}', 'fun_id');
        $this->createIndex('{{%idx-booking_funs_extra_assign-extra_id}}', '{{%booking_funs_extra_assign}}', 'extra_id');

        $this->addForeignKey('{{%fk-booking_funs_extra_assign-fun_id}}', '{{%booking_funs_extra_assign}}', 'fun_id', '{{%booking_funs}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_funs_extra_assign-extra_id}}', '{{%booking_funs_extra_assign}}', 'extra_id', '{{%booking_funs_extra}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_extra_assign}}');
    }
}
