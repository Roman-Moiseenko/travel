<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%selling_tour}}`.
 */
class m201123_135413_create_selling_tour_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%selling_tour}}', [
            'id' => $this->primaryKey(),
            'calendar_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-selling_tour-calendar_id}}', '{{%selling_tour}}', 'calendar_id');
        $this->addForeignKey('{{%fk-selling_tour-calendar_id}}', '{{%selling_tour}}', 'calendar_id', '{{%booking_tours_calendar_cost}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%selling_tour}}');
    }
}
