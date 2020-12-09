<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_characteristics}}`.
 */
class m201201_091143_create_booking_funs_characteristics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_characteristics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type_variable' => $this->integer()->notNull(),
            'type_fun_id' => $this->integer()->notNull(),
            'required' => $this->boolean()->notNull(),
            'default' => $this->string(),
            'variants_json' => 'JSON NOT NULL',
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_funs_characteristics-type_fun_id}}', '{{%booking_funs_characteristics}}', 'type_fun_id');
        $this->addForeignKey('{{%fk-booking_funs_characteristics-type_fun_id}}', '{{%booking_funs_characteristics}}', 'type_fun_id', '{{%booking_funs_type}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_characteristics}}');
    }
}
