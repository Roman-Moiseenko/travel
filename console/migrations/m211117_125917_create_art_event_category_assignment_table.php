<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%art_event_category_assignment}}`.
 */
class m211117_125917_create_art_event_category_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%art_event_category_assignment}}', [
            'event_id' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('{{%pk-art_event_category_assignment}}', '{{%art_event_category_assignment}}', ['event_id', 'category_id']);

        $this->createIndex('{{%idx-art_event_category_assignment-room_id}}', '{{%art_event_category_assignment}}', 'event_id');
        $this->createIndex('{{%idx-art_event_category_assignment-comfort_id}}', '{{%art_event_category_assignment}}', 'category_id');

        $this->addForeignKey(
            '{{%fk-art_event_category_assignment-room_id}}',
            '{{%art_event_category_assignment}}',
            'event_id',
            '{{%art_event}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey(
            '{{%fk-art_event_category_assignment-comfort_id}}',
            '{{%art_event_category_assignment}}',
            'category_id',
            '{{%art_event_category}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%art_event_category_assignment}}');
    }
}
