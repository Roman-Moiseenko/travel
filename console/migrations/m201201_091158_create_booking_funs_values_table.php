<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_value}}`.
 */
class m201201_091158_create_booking_funs_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_values}}', [
            'fun_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_funs_values}}', '{{%booking_funs_values}}', ['fun_id', 'characteristic_id']);

        $this->createIndex('{{%idx-booking_funs_values-fun_id}}', '{{%booking_funs_values}}', 'fun_id');
        $this->createIndex('{{%idx-booking_funs_values-characteristic_id}}', '{{%booking_funs_values}}', 'characteristic_id');
        $this->addForeignKey('{{%fk-booking_funs_values-fun_id}}', '{{%booking_funs_values}}', 'fun_id', '{{%booking_funs}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_funs_values-characteristic_id}}', '{{%booking_funs_values}}', 'characteristic_id', '{{%booking_funs_characteristics}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_values}}');
    }
}
