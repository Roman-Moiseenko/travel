<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%selling_stay}}`.
 */
class m210322_135424_create_selling_stay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%selling_stay}}', [
            'id' => $this->primaryKey(),
            'calendar_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-selling_stay-calendar_id}}', '{{%selling_stay}}', 'calendar_id');
        $this->addForeignKey('{{%fk-selling_stay-calendar_id}}', '{{%selling_stay}}', 'calendar_id', '{{%booking_stays_calendar_cost}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%selling_stay}}');
    }
}
