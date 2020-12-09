<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%selling_fun}}`.
 */
class m201201_215334_create_selling_fun_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%selling_fun}}', [
            'id' => $this->primaryKey(),
            'calendar_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-selling_fun-calendar_id}}', '{{%selling_fun}}', 'calendar_id');
        $this->addForeignKey('{{%fk-selling_fun-calendar_id}}', '{{%selling_fun}}', 'calendar_id', '{{%booking_funs_calendar_cost}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%selling_fun}}');
    }
}
